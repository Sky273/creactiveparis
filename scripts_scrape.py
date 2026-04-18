import urllib.request, re, html, json, os, concurrent.futures, sys
from urllib.parse import urljoin

repo='/tmp/creactiveparis'
base='https://www.creactive-paris.fr/'
seed_pages=[base, base+'creasmart-accessoires-design-et-originaux/', base+'creasoft-accessoires-de-salle-de-bain/', base+'creamust-accessoires-haut-de-gamme/']
headers={'User-Agent':'Mozilla/5.0'}

def fetch(url):
    req=urllib.request.Request(url, headers=headers)
    with urllib.request.urlopen(req, timeout=25) as r:
        return r.read().decode('utf-8','ignore')

def strip_tags(s):
    s=re.sub(r'<[^>]+>',' ',s)
    return ' '.join(html.unescape(s).split())

seed_html=[fetch(u) for u in seed_pages]
gamme_links=sorted(set(
    urljoin(page, html.unescape(link)).split('#')[0]
    for page,text in zip(seed_pages, seed_html)
    for link in re.findall(r'href=["\']([^"\']+)["\']', text)
    if '/gamme/' in link or '/gamme/' in urljoin(page, html.unescape(link))
))
print('gammes', len(gamme_links), flush=True)

def parse_gamme(gamme_url):
    ghtml=fetch(gamme_url)
    m=re.search(r'<h1[^>]*>(.*?)</h1>', ghtml, re.S)
    gamme_name=strip_tags(m.group(1)) if m else gamme_url.rstrip('/').split('/')[-1]
    intros=[]
    for p in re.findall(r'<p>(.*?)</p>', ghtml, re.S):
        txt=strip_tags(p)
        if txt and txt not in ['Finition'] and 'En savoir plus' not in txt and len(txt)>20:
            intros.append(txt)
    intro='\n\n'.join(intros[:3])
    prod_links=sorted(set(urljoin(gamme_url, html.unescape(l)).split('#')[0] for l in re.findall(r'href=["\']([^"\']+)["\']', ghtml) if '/produit/' in l))
    return gamme_url, gamme_name, intro, prod_links

gammes=[]
with concurrent.futures.ThreadPoolExecutor(max_workers=8) as ex:
    for i,res in enumerate(ex.map(parse_gamme, gamme_links),1):
        gammes.append(res)
        print('parsed gamme', i, flush=True)

product_urls=[]
for gamme_url,gamme_name,intro,links in gammes:
    for u in links:
        product_urls.append((u, gamme_name, intro))
seen=set(); dedup=[]
for item in product_urls:
    if item[0] not in seen:
        dedup.append(item); seen.add(item[0])
print('products', len(dedup), flush=True)

def parse_product(item):
    url, default_gamme, gamme_intro = item
    phtml=fetch(url)
    m=re.search(r'<h1[^>]*>(.*?)</h1>', phtml, re.S)
    name=strip_tags(m.group(1)) if m else url.rstrip('/').split('/')[-1]
    cm=re.search(r'<p class="uppercase collection_gamme">(.*?)</p>', phtml, re.S)
    collection=''; gamme=default_gamme
    if cm:
        txt=strip_tags(cm.group(1))
        parts=[x.strip() for x in txt.split('|') if x.strip()]
        if len(parts)>=2:
            collection, gamme = parts[0], parts[1]
        elif len(parts)==1:
            gamme=parts[0]
    sm=re.search(r'<p class="uppercase f12">\s*([^<]+)\s*</p>', phtml)
    sku=sm.group(1).strip() if sm else ''
    finishes=[strip_tags(x) for x in re.findall(r'<span class="ml-2 f13 mt-0">\s*(.*?)\s*</span>', phtml, re.S)]
    tech=re.search(r"href=\"(https://www\.creactive-paris\.fr/[^\"]+fiche-technique[^\"]+)\"", phtml)
    tech_pdf=html.unescape(tech.group(1)) if tech else ''
    images=[]
    for im in re.findall(r'<meta property="og:image" content="([^"]+)"', phtml):
        images.append(im)
    pre=phtml[:phtml.find('<div class="produit_introduction">') if '<div class="produit_introduction">' in phtml else len(phtml)]
    for im in re.findall(r'src="(https://www\.creactive-paris\.fr/wp-content/uploads/[^"]+?)"', pre):
        if any(ext in im.lower() for ext in ['.jpg','.jpeg','.png','.webp']):
            images.append(im)
    images=list(dict.fromkeys(images))
    details=[]
    for label,val in re.findall(r'<div class="d-flex flex-row align-items-center justify-content-between">\s*<p class="semibold">\s*(.*?)\s*</p>\s*<p>(.*?)</p>', phtml, re.S):
        label=strip_tags(label)
        val=strip_tags(val)
        if label and val:
            details.append((label,val))
    d={k:v for k,v in details}
    def pick(*keys):
        for k in keys:
            if k in d and d[k]: return d[k]
        return ''
    material=pick('Matière')
    width=pick('Largeur (mm)','Largeur')
    depth=pick('Profondeur (mm)','Profondeur')
    height=pick('Hauteur (mm)','Hauteur')
    short=[]
    if material: short.append(f'Matière : {material}.')
    if finishes: short.append('Finitions : ' + ', '.join(finishes) + '.')
    dims=' x '.join([x for x in [width, depth, height] if x])
    if dims: short.append(f'Dimensions (L x P x H mm) : {dims}.')
    desc=gamme_intro.strip()
    if tech_pdf: desc += ('\n\n' if desc else '') + f'Fiche technique : {tech_pdf}'
    return {
        'name':name,'slug':url.rstrip('/').split('/')[-1],'sku':sku,'collection':collection,'gamme':gamme,
        'url':url,'description':desc,'short_description':' '.join(short),'finishes':finishes,'material':material,
        'width_mm':width,'depth_mm':depth,'height_mm':height,'images':images,'tech_pdf':tech_pdf,
    }

products=[]
with concurrent.futures.ThreadPoolExecutor(max_workers=20) as ex:
    for i,p in enumerate(ex.map(parse_product, dedup),1):
        products.append(p)
        if i % 25 == 0:
            print('parsed product', i, flush=True)
products=sorted(products, key=lambda x:(x['collection'],x['gamme'],x['name'],x['sku']))
os.makedirs(os.path.join(repo,'data'), exist_ok=True)
with open(os.path.join(repo,'data','scraped-products.json'),'w',encoding='utf-8') as f:
    json.dump(products,f,ensure_ascii=False,indent=2)
print('done', len(products), flush=True)
