@extends('layouts.app')

@section('content')
<x-legal-layout title="Terms and Conditions">
    <!-- Introduction -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">1. Introduction &amp; Acceptance of Terms</h2>
        <p class="text-soft-gray">
            Welcome to <strong>Ashma Creations</strong>. These Terms and Conditions govern your access to and use of our website and services, including any purchases of our handcrafted items, custom bouquets, flower pots, and decorative designs. 
        </p>
        <p class="text-soft-gray mt-4">
            By browsing our website, submitting inquiries, or purchasing products, you accept and agree to be bound by these Terms. If you disagree with any part of these terms, please discontinue using our website and services immediately.
        </p>
    </div>

    <!-- Handcrafted Nature of Products -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">2. Handcrafted Product Disclosures</h2>
        <p class="text-soft-gray">
            All products created by Ashma Creations are <strong>100% handmade</strong>. Due to the artistic and bespoke nature of our craftsmanship (specifically using pipe cleaners, fabric, wires, and organic accessories):
        </p>
        <ul class="list-disc pl-6 mt-4 text-soft-gray space-y-2">
            <li>Slight variations in color, shading, texture, shape, and final dimensions are normal and to be expected.</li>
            <li>Product photos displayed on our website represent design concepts; minor differences in the final product you receive should be embraced as unique characteristics of handmade art.</li>
            <li>Color accuracy depends on your screen configuration, and we cannot guarantee that your monitor's display will perfectly replicate the physical colors of our items.</li>
        </ul>
    </div>

    <!-- Custom Orders -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">3. Custom Orders &amp; Personalization</h2>
        <p class="text-soft-gray">
            We specialize in custom orders to bring your unique floral and craft visions to life. When requesting custom commissions (e.g., specific flower configurations, custom colors, specialized pots, or bulk event bouquets):
        </p>
        <ul class="list-disc pl-6 mt-4 text-soft-gray space-y-2">
            <li><strong>Design Approvals:</strong> Once a custom design, layout, or color palette has been finalized and approved by you via WhatsApp or Email, modifications cannot be guaranteed.</li>
            <li><strong>Production Timelines:</strong> Handcrafting premium creations takes time. Crafting timelines are estimated at the time of order confirmation and are subject to change based on design complexity and materials sourcing.</li>
        </ul>
    </div>

    <!-- Pricing and Payments -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">4. Pricing, Payments, &amp; Billing</h2>
        <p class="text-soft-gray">
            All prices listed on our site are displayed in INR (Indian Rupee) unless specified otherwise. 
        </p>
        <ul class="list-disc pl-6 mt-4 text-soft-gray space-y-2">
            <li>We reserve the right to change prices for any product or service at any time without prior notice.</li>
            <li>For standard, in-stock products, full payment is required at checkout before shipment.</li>
            <li>For custom commissions or bulk orders, a non-refundable deposit or full advance payment may be required before we commence crafting your order.</li>
        </ul>
    </div>

    <!-- Shipping and Delivery -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">5. Shipping, Handling, &amp; Delivery</h2>
        <p class="text-soft-gray">
            We take utmost care in packaging our delicate items to prevent damage during transport.
        </p>
        <ul class="list-disc pl-6 mt-4 text-soft-gray space-y-2">
            <li><strong>Processing Times:</strong> Standard in-stock items are shipped within 2–3 business days. Custom orders follow the personalized production schedule communicated during checkout.</li>
            <li><strong>Carrier Responsibility:</strong> Once shipped, shipping speeds, logistics delays, or carrier-related damages are beyond our direct control.</li>
            <li><strong>Receipt Inspection:</strong> Please inspect your parcel immediately upon arrival. In the rare event of transit damage, you must contact us within 48 hours of delivery, providing photos of the outer box and the damaged product, so we can assist you.</li>
        </ul>
    </div>

    <!-- Cancellation and Return Policy -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">6. Cancellation, Return, &amp; Refund Policy</h2>
        <p class="text-soft-gray">
            Due to the bespoke nature and high degree of personalization of handcrafted flower bouquets:
        </p>
        <ul class="list-disc pl-6 mt-4 text-soft-gray space-y-2">
            <li><strong>Customized &amp; Made-to-Order Items:</strong> All sales of custom-made products are final. Returns, exchanges, or refunds are not permitted for personalized items.</li>
            <li><strong>Standard Products:</strong> Returns or refunds are only accepted for defective products or items damaged in transit, provided you report the issue within 48 hours of delivery.</li>
            <li><strong>Order Cancellations:</strong> Standard orders can be cancelled only if they have not yet been shipped. Custom commissions cannot be cancelled once raw material procurement or physical crafting has begun.</li>
        </ul>
    </div>

    <!-- Intellectual Property -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">7. Intellectual Property Rights</h2>
        <p class="text-soft-gray">
            All content on this website, including but not limited to branding, design templates, layouts, photographs, and our handcrafted flower patterns, is the property of <strong>Ashma Creations</strong>.
        </p>
        <p class="text-soft-gray mt-4">
            You may not copy, download, modify, republish, distribute, sell, or reverse-engineer any product designs or website content without our express prior written consent.
        </p>
    </div>

    <!-- Limitation of Liability -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">8. Disclaimer &amp; Limitation of Liability</h2>
        <p class="text-soft-gray">
            Our website and handmade creations are provided on an "as is" and "as available" basis without warranties of any kind. 
        </p>
        <p class="text-soft-gray mt-4">
            Ashma Creations shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from the use or inability to use our products, including but not limited to minor differences in handmade styles, delivery delays, or minor wear and tear of delicate parts during shipping.
        </p>
    </div>

    <!-- Governing Law -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">9. Governing Law</h2>
        <p class="text-soft-gray">
            These Terms and Conditions and any separate agreements whereby we provide you services shall be governed by and construed in accordance with the laws of <strong>India</strong>, and any legal actions or disputes shall fall under the exclusive jurisdiction of the local courts of India.
        </p>
    </div>

    <!-- Contact Information -->
    <div class="border-t border-primary-light/30 pt-10">
        <h2 class="text-2xl font-heading text-primary mb-4">10. Contact Us</h2>
        <p class="text-soft-gray">
            If you have any questions or clarifications regarding these Terms and Conditions, please feel free to reach out to us:
        </p>
        <p class="text-soft-gray mt-4">
            <strong>Email:</strong> dheerajagarwal1995@gmail.com<br>
            <strong>Inquiries:</strong> <a href="{{ route('contact') }}" class="text-primary hover:text-accent font-semibold underline">Contact Us Form</a><br>
            <strong>Last Updated:</strong> June 19, 2026
        </p>
    </div>
</x-legal-layout>
@endsection
