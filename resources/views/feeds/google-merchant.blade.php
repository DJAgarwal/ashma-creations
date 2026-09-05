<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL; ?>
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">
  <channel>
    <title><![CDATA[Ashma Creations - Handcrafted Flowers & Personalized Gifts]]></title>
    <link>{{ url('/') }}</link>
    <description><![CDATA[Handcrafted pipe cleaner flowers, everlasting bouquets, flower pots, and bespoke personalized gifts by Ashma Creations.]]></description>
    <lastBuildDate>{{ now()->toRfc2822String() }}</lastBuildDate>
@foreach($products as $product)
    @php
        $canonicalUrl = route('products.show', $product->slug);
        
        // Clean Title (Max 150 chars, no HTML, CDATA safe)
        $title = Str::limit(trim(strip_tags($product->name)), 150, '');
        $title = str_replace(']]>', ']]&gt;', $title);

        // Clean Description (Plain text, strip HTML, sanitize whitespace, max 5000 chars, CDATA safe)
        $rawDesc = !empty($product->description) ? $product->description : (!empty($product->details) ? $product->details : $product->meta_description);
        $cleanDesc = trim(preg_replace('/\s+/', ' ', strip_tags($rawDesc ?: 'Handcrafted ' . $product->name . ' by Ashma Creations. Beautifully crafted with care in India.')));
        $cleanDesc = Str::limit($cleanDesc, 5000, '');
        $cleanDesc = str_replace(']]>', ']]&gt;', $cleanDesc);

        // Primary & Additional Images
        $images = !empty($product->images) && is_array($product->images) ? array_values(array_filter($product->images)) : [];
        $primaryImage = !empty($images[0]) 
            ? (filter_var($images[0], FILTER_VALIDATE_URL) ? $images[0] : asset($images[0])) 
            : url('/images/logo.webp');

        $additionalImages = [];
        if (count($images) > 1) {
            foreach (array_slice($images, 1, 10) as $addImg) {
                if (!empty($addImg)) {
                    $additionalImages[] = filter_var($addImg, FILTER_VALIDATE_URL) ? $addImg : asset($addImg);
                }
            }
        }

        // Pricing (ISO 4217 Currency: INR)
        $price = (isset($product->price) && (float)$product->price > 0) ? (float)$product->price : 65.00;
        $formattedPrice = number_format($price, 2, '.', '') . ' INR';

        // Dynamic Real Category Breadcrumb Hierarchy from Database
        $categoryHierarchy = [];
        $currCat = $product->primaryCategory;
        while ($currCat) {
            array_unshift($categoryHierarchy, trim($currCat->name));
            $currCat = $currCat->parent;
        }
        $realCategoryPath = !empty($categoryHierarchy) ? implode(' > ', $categoryHierarchy) : 'General';
        $primaryCatName = $product->primaryCategory ? trim($product->primaryCategory->name) : '';

        // Primary Material
        $materialName = ($product->materials && $product->materials->isNotEmpty()) ? $product->materials->first()->name : 'Chenille Pipe Cleaner';

        // Descriptive Custom Labels (Segmented for Shopping campaigns)
        $labels = \App\Http\Controllers\GoogleFeedController::resolveCustomLabels($product);
    @endphp
    <item>
      <g:id>ashma-{{ $product->id }}</g:id>
      <title><![CDATA[{!! $title !!}]]></title>
      <g:title><![CDATA[{!! $title !!}]]></g:title>
      <description><![CDATA[{!! $cleanDesc !!}]]></description>
      <g:description><![CDATA[{!! $cleanDesc !!}]]></g:description>
      <link>{{ $canonicalUrl }}</link>
      <g:link>{{ $canonicalUrl }}</g:link>
      <g:image_link>{{ $primaryImage }}</g:image_link>
@foreach($additionalImages as $addImgUrl)
      <g:additional_image_link>{{ $addImgUrl }}</g:additional_image_link>
@endforeach
      <g:availability>in_stock</g:availability>
      <g:price>{{ $formattedPrice }}</g:price>
      <g:brand><![CDATA[Ashma Creations]]></g:brand>
      <g:condition>new</g:condition>
      <g:identifier_exists>no</g:identifier_exists>
      <category><![CDATA[{!! $realCategoryPath !!}]]></category>
      <g:product_type><![CDATA[{!! $realCategoryPath !!}]]></g:product_type>
      <g:google_product_category><![CDATA[{!! $realCategoryPath !!}]]></g:google_product_category>
      <g:shipping>
        <g:country>IN</g:country>
        <g:service>Standard Delivery</g:service>
        <g:price>80.00 INR</g:price>
      </g:shipping>
@if(isset($product->weight) && (float)$product->weight > 0)
    @php
        $w = (float)$product->weight;
        $weightStr = ($w == (int)$w ? (int)$w : number_format($w, 1, '.', '')) . ' g';
    @endphp
      <g:shipping_weight>{{ $weightStr }}</g:shipping_weight>
@endif
      <g:material><![CDATA[{!! $materialName !!}]]></g:material>
      <g:custom_label_0><![CDATA[{!! $labels['custom_label_0'] !!}]]></g:custom_label_0>
      <g:custom_label_1><![CDATA[{!! $labels['custom_label_1'] !!}]]></g:custom_label_1>
      <g:custom_label_2><![CDATA[{!! $labels['custom_label_2'] !!}]]></g:custom_label_2>
      <g:custom_label_3><![CDATA[{!! $labels['custom_label_3'] !!}]]></g:custom_label_3>
      <g:custom_label_4><![CDATA[{!! $labels['custom_label_4'] !!}]]></g:custom_label_4>
      <guid isPermaLink="true">{{ $canonicalUrl }}</guid>
    </item>
@endforeach
  </channel>
</rss>
