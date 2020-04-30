"use strict";
$(document).ready(function() {
						   
! function(t) {
    t.widget("llapgoch.stepper", {
        options: {
            upSelector: ".js-qty-up",
            downSelector: ".js-qty-down",
            inputSelector: ".js-qty-input",
            disabledClass: "disabled",
            maxQty: 999,
            minQty: 1,
            step: 1
        },
        originalValue: null,
        value: 0,
        _create: function() {
            this._super(), this._addEvents();
            var t = this._validateValue(this._getInput().val());
            this._getInput().val(t), this.originalValue = t, this.value = t
        },
        disable: function() {
            this._super(), this._getInput().prop("disabled", "disabled").addClass(this.options.disabledClass), this._getDownElement().addClass(this.options.disabledClass), this._getUpElement().addClass(this.options.disabledClass)
        },
        enable: function() {
            this._super(), this._getInput().removeProp("disabled").addClass(this.options.disabledClass), this._getDownElement().removeClass(this.options.disabledClass), this._getUpElement().removeClass(this.options.disabledClass)
        },
        _validateValue: function(t) {
            return t = parseFloat(t), t = isNaN(t) ? 1 : t, Math.max(this.options.minQty, Math.min(t, this.options.maxQty))
        },
        _addEvents: function() {
            var t = this,
                e = {};
            e["click " + this.options.upSelector] = function(e) {
                e.preventDefault(), t.stepQuantity(t.options.step)
            }, e["click " + this.options.downSelector] = function(e) {
                e.preventDefault(), t.stepQuantity(-t.options.step)
            }, e["keyup " + this.options.inputSelector] = function(e) {
                var i = t._getInput().val();
                "" === i || isNaN(parseFloat(i)) || t.updateQuantity(i)
            }, e["blur " + this.options.inputSelector] = function(e) {
                t.updateQuantity(t.value)
            }, this._on(this.element, e)
        },
        _fireEvent: function(e, i, s) {
            s = s || {}, this._trigger(e, i, t.extend({}, s, {
                element: this.element
            }))
        },
        _fireUpdate: function(t) {
            var e = "same_value_entered";
            this.value != this.originalValue && (e = "different_value_entered"), this._fireEvent("update", t, {
                value: this.value,
                updateType: e
            })
        },
        _getInput: function() {
            return t(this.options.inputSelector, this.element)
        },
        _getUpElement: function() {
            return t(this.options.upSelector, this.element)
        },
        _getDownElement: function() {
            return t(this.options.downSelector, this.element)
        },
        updateQuantity: function(t) {
            this.value = this._validateValue(t), this._getInput().val(this.value), this._fireUpdate()
        },
        stepQuantity: function(t) {
            this.updateQuantity(this.value + t)
        },
        getValue: function() {
            return this.value
        }
    })
}(jQuery), jQuery(document).on("ready", function() {
    jQuery(".stepper-widget").stepper(), jQuery(".stepper-widget").on("stepperupdate", function(t, e) {
        console.log(e.updateType)
    })
});

	
});