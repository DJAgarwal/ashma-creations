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

        // Categories & Taxonomy
        $catName = $product->primaryCategory ? trim($product->primaryCategory->name) : '';
        $parentCatName = ($product->primaryCategory && $product->primaryCategory->parent) ? trim($product->primaryCategory->parent->name) : '';
        
        // Build product_type breadcrumb hierarchy (e.g. Handmade Gifts > Flower Pot > Mini Flower Pot)
        $productTypeParts = array_filter(['Handmade Gifts', $parentCatName, $catName]);
        $productType = implode(' > ', $productTypeParts);

        // Google Product Category mapping
        $lowerSearch = strtolower($product->name . ' ' . $catName . ' ' . $parentCatName);
        if (str_contains($lowerSearch, 'pot') || str_contains($lowerSearch, 'plant')) {
            $googleCategory = 'Home & Garden > Decor > Artificial Flora > Artificial Plants';
        } elseif (str_contains($lowerSearch, 'keychain') || str_contains($lowerSearch, 'pin') || str_contains($lowerSearch, 'accessory')) {
            $googleCategory = 'Apparel & Accessories > Handbag & Wallet Accessories > Keychains';
        } else {
            $googleCategory = 'Home & Garden > Decor > Artificial Flora > Artificial Flowers';
        }

        // Custom Labels (for Google Shopping segmentation & reporting)
        $badge = 'Standard';
        if ($product->is_featured) $badge = 'Featured';
        elseif ($product->is_best_seller) $badge = 'Best Seller';
        elseif ($product->is_new_arrival) $badge = 'New Arrival';
        elseif ($product->is_trending) $badge = 'Trending';

        // Primary Material
        $materialName = ($product->materials && $product->materials->isNotEmpty()) ? $product->materials->first()->name : 'Chenille Pipe Cleaner';

        // Primary Occasion & Recipient
        $occasionName = ($product->occasions && $product->occasions->isNotEmpty()) ? $product->occasions->first()->name : '';
        $recipientName = ($product->recipients && $product->recipients->isNotEmpty()) ? $product->recipients->first()->name : '';
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
      <g:google_product_category><![CDATA[{!! $googleCategory !!}]]></g:google_product_category>
      <g:product_type><![CDATA[{!! $productType !!}]]></g:product_type>
      <g:shipping>
        <g:country>IN</g:country>
        <g:service>Standard Delivery</g:service>
        <g:price>100.00 INR</g:price>
      </g:shipping>
      <g:shipping_weight>0.35 kg</g:shipping_weight>
      <g:material><![CDATA[{!! $materialName !!}]]></g:material>
      <g:custom_label_0><![CDATA[{!! $badge !!}]]></g:custom_label_0>
@if(!empty($catName))
      <g:custom_label_1><![CDATA[{!! $catName !!}]]></g:custom_label_1>
@endif
@if(!empty($occasionName))
      <g:custom_label_2><![CDATA[{!! $occasionName !!}]]></g:custom_label_2>
@endif
@if(!empty($recipientName))
      <g:custom_label_3><![CDATA[{!! $recipientName !!}]]></g:custom_label_3>
@endif
      <g:custom_label_4><![CDATA[Handcrafted in India]]></g:custom_label_4>
      <guid isPermaLink="true">{{ $canonicalUrl }}</guid>
    </item>
@endforeach
  </channel>
</rss>
