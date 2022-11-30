<?xml version="1.0" encoding="utf-8"?>
  <?xml-stylesheet href="https://www.alpissime.com/xml/tent.xsl" type="text/xsl"?>
  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
  <loc>https://www.alpissime.com/</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>1.00</priority>
</url>
<url>
  <loc>https://www.alpissime.com/utilisateurs/ouvrircompte</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.80</priority>
</url>
	
    <url>
  <loc>https://www.alpissime.com/annonces/contact</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.80</priority>
</url>
<url>
  <loc>https://www.alpissime.com/annonces</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.alpissime.com/utilisateurs/add</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.alpissime.com/utilisateurs/add/compte</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.alpissime.com/utilisateurs/mdpPerdu</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.alpissime.com/annonces/liste</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.64</priority>
</url>
<url>
  <loc>https://www.alpissime.com/annonces/recherche</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.51</priority>
</url>
<url>
  <loc>https://www.alpissime.com/utilisateurs/erreurconnexion</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.51</priority>
</url>
<url>
  <loc>https://www.alpissime.com/annonces/recherche/</loc>
  <lastmod>07/02/2017 14:21</lastmod>
  <changefreq>always</changefreq>
  <priority>0.51</priority>
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
