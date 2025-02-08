<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.quote_title') }}</title>
</head>
<body>
    <form action="{{ route('quote.send') }}" method="POST">
        @csrf
        <label>{{ __('messages.client_name') }}</label>
        <input type="text" name="client_name" required>

        <label>Email du client</label>
        <input type="email" name="client_email" required>

        <div id="products">
            <div>
                <input type="text" name="products[]" placeholder="{{ __('messages.products') }}" required>
                <input type="number" name="quantities[]" placeholder="{{ __('messages.quantity') }}" required>
                <input type="number" name="prices[]" placeholder="{{ __('messages.price') }}" required>
            </div>
        </div>

        <button type="submit">{{ __('messages.send_email') }}</button>
    </form>
</body>
</html>
