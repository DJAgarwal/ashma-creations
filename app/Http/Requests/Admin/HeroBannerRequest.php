<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HeroBannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isCreate = $this->isMethod('post');

        return [
            'link_type' => [
                'required',
                'string',
                Rule::in(['Category', 'Collection', 'Occasion', 'Recipient', 'Product', 'Page', 'Custom URL']),
            ],
            'link_id' => ['nullable', 'string', 'max:255'],
            'custom_url' => [
                Rule::requiredIf(fn () => in_array($this->input('link_type'), ['Custom URL', 'custom_url', 'custom'])),
                'nullable',
                'string',
                'max:1000',
            ],

            'desktop_image' => [
                $isCreate ? 'required' : 'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:10240', // 10MB
            ],
            'mobile_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:10240',
            ],

            'active' => ['nullable', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'desktop_image.required' => 'A desktop banner image is required.',
            'desktop_image.image' => 'Desktop file must be a valid image.',
            'mobile_image.image' => 'Mobile file must be a valid image.',
            'custom_url.required_if' => 'Please specify a custom URL when Custom URL destination is selected.',
        ];
    }
}
