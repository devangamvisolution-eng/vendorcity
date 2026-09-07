<div class="back-button-wrapper my-3">
    <a href="{{ $url }}" {{ $attributes->merge(['class' => 'btn-back-custom']) }}>
        <i class="fa fa-chevron-left"></i>
        <span>{{ $label }}</span>
    </a>
</div>


<style>
    /* Back Button Style */
    /* Container to ensure spacing */
    .back-button-wrapper {
        margin-bottom: 25px;
        display: flex;
        justify-content: flex-start;
    }

    /* The Button Styling */
    .btn-back-custom {
        display: inline-flex;
        align-items: center;
        background-color: #ffffff;
        /* Clean white background */
        color: #333333;
        /* Professional dark grey text */
        padding: 8px 18px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Icon spacing */
    .btn-back-custom i {
        margin-right: 10px;
        font-size: 12px;
    }

    /* Hover State - Lifts slightly and changes color */
    .btn-back-custom:hover {
        background-color: #282828;
        /* Matches your sidebar/text color */
        color: #ffffff !important;
        border-color: #282828;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* Active/Click State */
    .btn-back-custom:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    @media (min-width: 992px) {
        .back-button-wrapper {
            display: none !important;
        }
    }
</style>
