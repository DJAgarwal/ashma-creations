@extends('layouts.app')

@section('content')
<x-legal-layout title="Disclaimer">
    <!-- General Information Disclaimer -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">1. General Information</h2>
        <p class="text-soft-gray">
            All content and information published on the <strong>Ashma Creations</strong> website (https://ashma-creations.com) are provided in good faith and for general promotional, catalog, and information purposes only. While we strive to maintain accurate, up-to-date, and error-free content, Ashma Creations makes no warranties or representations of any kind, express or implied, regarding the completeness, reliability, suitability, or accuracy of the information, product lists, designs, or graphics featured on this website.
        </p>
        <p class="text-soft-gray mt-4">
            Any action you take based on the information found on this website is strictly at your own risk. Ashma Creations will not be held liable for any losses, damages, or disappointments incurred in connection with the use of our website or products.
        </p>
    </div>

    <!-- Handcrafted Nature of Products -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">2. Handcrafted Product Disclaimer</h2>
        <p class="text-soft-gray">
            Every item cataloged on our website is <strong>100% handmade</strong> with meticulous care by our craft artisans. Because of the bespoke and manual production process using pipe cleaners, fabric, hot glue, wire frame templates, and decorative accessories:
        </p>
        <ul class="list-disc pl-6 mt-4 text-soft-gray space-y-2">
            <li><strong>Unique Variations:</strong> No two products are identical. Minor differences in sizing, shape, stitch symmetry, or final configuration are intrinsic to handmade craftsmanship and should not be viewed as defects.</li>
            <li><strong>Material Availability:</strong> Subtle differences in color dye lots or packaging accessories (e.g., bouquet wrapping paper styles, ribbons, or flower pots) may occur depending on material sourcing and supplier batches.</li>
        </ul>
    </div>

    <!-- Visual and Screen Accuracy -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">3. Visual Representation &amp; Color Accuracy</h2>
        <p class="text-soft-gray">
            We make every effort to display the colors and details of our handmade flowers as accurately as possible. However:
        </p>
        <p class="text-soft-gray mt-4">
            The colors you see depend heavily on your device's screen configuration, brightness, display settings, and viewing angle. We cannot guarantee that your monitor or phone display will perfectly represent the true physical colors of the items you receive.
        </p>
    </div>

    <!-- Safety and Usage Disclaimer -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">4. Safety &amp; Usage Disclosures</h2>
        <p class="text-soft-gray">
            Our products (handmade bouquets, single stem flowers, custom pots, and accessories) are designed, manufactured, and sold solely for <strong>decorative and ornamental purposes</strong>. 
        </p>
        <p class="text-soft-gray mt-4">
            <strong>Choking & Safety Hazard Warning:</strong> Many of our creations contain small parts, wires, beads, floral tape, and hot glue. They are <strong>not toys</strong> and are not suitable for infants, pets, or young children without close adult supervision. Wires inside pipe cleaner stems can be sharp if exposed. Ashma Creations disclaims all liability for injuries arising from the misuse or unsupervised handling of our decorative items.
        </p>
    </div>

    <!-- External Links Disclaimer -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">5. External Links Disclaimer</h2>
        <p class="text-soft-gray">
            Our website may contain hyperlinks to external sites, social media handles (such as Instagram or WhatsApp), or payment channels. While we endeavor to provide only high-quality links to ethical and useful websites, we have no control over the content, updates, or privacy policies of these external platforms. A link to another site does not imply an endorsement for all the content found there.
        </p>
    </div>

    <!-- Limitation of Liability -->
    <div>
        <h2 class="text-2xl font-heading text-primary mb-4">6. Limitation of Liability</h2>
        <p class="text-soft-gray">
            To the maximum extent permitted by applicable law, Ashma Creations and its associates shall not be liable for any direct, indirect, incidental, consequential, or punitive damages—including but not limited to loss of profits, delivery disruptions, transit damage, or minor differences in expectation—resulting from your visit to our website or your purchase of our custom handmade items.
        </p>
    </div>

    <!-- Contact Information -->
    <div class="border-t border-primary-light/30 pt-10">
        <h2 class="text-2xl font-heading text-primary mb-4">7. Contact Us</h2>
        <p class="text-soft-gray">
            If you require any more information or have any questions about our website's disclaimer, please feel free to contact us by email:
        </p>
        <p class="text-soft-gray mt-4">
            <strong>Email:</strong> <a href="mailto:ashmacreations07@gmail.com" class="text-primary hover:text-accent font-semibold underline">ashmacreations07@gmail.com</a><br>
            <strong>Inquiries:</strong> <a href="{{ route('contact') }}" class="text-primary hover:text-accent font-semibold underline">Contact Us Form</a><br>
            <strong>Last Updated:</strong> June 19, 2026
        </p>
    </div>
</x-legal-layout>
@endsection
