<?xml version="1.0" encoding="utf-8"?>
  <?xml-stylesheet href="https://www.alpissime.com/xml/tent.xsl" type="text/xsl"?>
  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://www.alpissime.com/</loc>
        <lastmod>15/11/2016 15:06</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url> 
        <loc>https://www.alpissime.com/contact.html</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
	<url>
        <loc>https://www.alpissime.com/</loc>
        <lastmod>15/11/2016 15:06</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url> 
        <loc>https://www.alpissime.com/contact.html</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>http://www.boutique.alpissime.com</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>http://www.boutique.alpissime.com/service.html</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/archives</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/conditions-generales-de-vente</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/conditions-generales/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/contributeurs-2/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/faq/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/videos-2/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/lexique-de-la-location-sur-alpissime-com/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/liens/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/liens-referencement/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>http:/www.blog.alpissime.com/mentions-legales/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/newsletters/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/page-dinscription/</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url> 
        <loc>https://www.alpissime.com/blog/qui-somme-nous</loc> 
        <lastmod>15/11/2016 15:06</lastmod>
        <priority>0.4</priority>
        <changefreq>yearly</changefreq>
    </url>
	<?php foreach($annonces as $annonce) :?>
	<url> 
        <loc>https://www.alpissime.com/detail/<?php echo $annonce["id"] ?>-<?php echo $this->annonceFormater->formatStr($annonce["titre"])?>.html</loc> 
        <lastmod><?php echo $annonce["updated_at"] ?></lastmod> 
        <priority>1.0</priority> 
        <changefreq>daily</changefreq>
    </url> 
	<?php endforeach;?>
	</urlset>