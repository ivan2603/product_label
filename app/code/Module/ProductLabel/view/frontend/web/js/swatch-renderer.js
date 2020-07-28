define([
    'jquery',
    'jquery/ui',
    'magento-swatch.renderer'
], function($){

    $.widget('module.SwatchRenderer', $.mage.SwatchRenderer, {

        /**
         * Event for swatch options
         *
         * @param {Object} $this
         * @param {Object} $widget
         * @private
         */
        _OnClick: function ($this, $widget) {
            var $parent = $this.parents('.' + $widget.options.classes.attributeClass),
                $wrapper = $this.parents('.' + $widget.options.classes.attributeOptionsWrapper),
                $label = $parent.find('.' + $widget.options.classes.attributeSelectedOptionLabelClass),
                attributeId = $parent.attr('attribute-id'),
                $input = $parent.find('.' + $widget.options.classes.attributeInput);

            if ($widget.inProductList) {
                $input = $widget.productForm.find(
                    '.' + $widget.options.classes.attributeInput + '[name="super_attribute[' + attributeId + ']"]'
                );
            }

            if ($this.hasClass('disabled')) {
                return;
            }

            if ($this.hasClass('selected')) {
                $parent.removeAttr('option-selected').find('.selected').removeClass('selected');
                $input.val('');
                $label.text('');
                $this.attr('aria-checked', false);
            } else {
                $parent.attr('option-selected', $this.attr('option-id')).find('.selected').removeClass('selected');
                $label.text($this.attr('option-label'));
                $input.val($this.attr('option-id'));
                $input.attr('data-attr-name', this._getAttributeCodeById(attributeId));
                $this.addClass('selected');
                $widget._toggleCheckedAttributes($this, $wrapper);
            }

            $widget._Rebuild();

            var selected_options = {};
            $('div.swatch-attribute').each(function(k,v){
                var attribute_id    = $(v).attr('attribute-id');
                var option_selected = $(v).attr('option-selected');
                if(!attribute_id || !option_selected){ return;}
                selected_options[attribute_id] = option_selected;
            });

            var product_id_index = $widget.options.jsonConfig.index;
            var found_ids;
            let attribute = [];
            $.each(product_id_index, function(product_id,attributes){
                var productIsSelected = function(attributes, selected_options){
                    return _.isEqual(attributes, selected_options);
                };
                if(productIsSelected(attributes, selected_options)){
                    found_ids = product_id;
                }
            });
            if ($widget.options.jsonConfig.custom_attribute[found_ids] !== undefined) {
                attribute = $widget.options.jsonConfig.custom_attribute[found_ids];
                $.map(attribute, function (value) {
                    if (value == 'free_shipping') {
                        $('.product-label').append("<div class='label green'><span><strong>Free Shipping</strong></span></div>");
                    } else if(value == 'best_seller') {
                        $('.product-label').append("<div class='label blue'><span><strong>Best Seller</strong></span></div>");
                    } else if(value == 'sale') {
                        $('.product-label').append("<div class='label red'><span><strong>Sale</strong></span></div>");
                    }

                });
            } else {
                $('.product-label').html("");
            }

            if ($widget.element.parents($widget.options.selectorProduct)
                    .find(this.options.selectorProductPrice).is(':data(mage-priceBox)')
            ) {
                $widget._UpdatePrice();
            }

            $widget._loadMedia();
            $input.trigger('change');
        }

    });

    return $.module.SwatchRenderer;
});

