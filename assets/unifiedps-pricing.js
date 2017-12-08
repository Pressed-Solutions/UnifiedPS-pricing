(function ($) {
    /**
     * Initialize all sliders
     */
    function rangeSlider() {
        var slider = $('.price-range'),
            range = $('input.range-slider');

        slider.each(function () {
            range.each(function () {
                updateVisibleQuantity($(this));
            });

            range.on('input', function () {
                updateVisibleQuantity($(this));
            });
        });
    }

    /**
     * Update the labels and price points
     * @param {object} slider jQuery object representing a DOM element
     */
    function updateVisibleQuantity(slider) {
        var sliderName = slider.attr('name'),
            valueLabel = $('label[for="' + sliderName + '"] .range-slider.value'),
            priceLabel = $('.price.' + sliderName + ' .monthly-amount'),
            unitLabel = $('.price.' + sliderName + ' .unit'),
            inputIndex = slider.val() - 1,
            quantityList = JSON.parse(decodeURIComponent(slider.data('quantity-list'))),
            selectedQuantity = quantityList[inputIndex];

        valueLabel.html(selectedQuantity.quantity);
        priceLabel.html(selectedQuantity.price);
        unitLabel.html(selectedQuantity.unit);
    }

    $(document).ready(function () {
        rangeSlider();
    });

})(jQuery);
