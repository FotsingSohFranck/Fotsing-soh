@component('mail::message')
# {{ __('messages.quote_title') }}

**{{ __('messages.client_name') }}:** {{ $data['client_name'] }}

## {{ __('messages.products') }}
@foreach ($data['items'] as $item)
- **{{ $item['name'] }}**: {{ $item['quantity'] }} x {{ $item['price'] }}€ = {{ $item['subtotal'] }}€
@endforeach

**{{ __('messages.total') }}:** {{ $data['total'] }}€

Merci,<br>
{{ config('app.name') }}
@endcomponent
