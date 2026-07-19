jQuery(function ($) {

    function calculateRow($row) {

        var qty = parseFloat($row.find('.casben-qty').val()) || 0;
        var price = parseFloat($row.find('.casben-price').val()) || 0;
        var discount = parseFloat($row.find('.casben-discount').val()) || 0;
        var taxRate = parseFloat($row.find('.casben-tax-rate').val()) || 0;

        var gross = qty * price;
        var taxable = Math.max(gross - discount, 0);
        var tax = taxable * taxRate / 100;
        var lineTotal = taxable + tax;

        $row.find('.casben-line-total').val(lineTotal.toFixed(2));

        return {
            subtotal: gross,
            discount: discount,
            tax: tax,
            total: lineTotal
        };

    }

    function calculateInvoice() {

        console.clear();

        var subtotal = 0;
        var discountTotal = 0;
        var taxTotal = 0;
        var grandTotal = 0;

        $('#casben-invoice-items-table tbody tr').each(function (index) {

            console.log(
                'Row:',
                index,
                'Qty:',
                $(this).find('.casben-qty').val(),
                'Price:',
                $(this).find('.casben-price').val()
            );

            var result = calculateRow($(this));

            console.log(result);

            subtotal += result.subtotal;
            discountTotal += result.discount;
            taxTotal += result.tax;
            grandTotal += result.total;

        });

        console.log('FINAL TOTALS', {
            subtotal: subtotal,
            discount: discountTotal,
            tax: taxTotal,
            grandTotal: grandTotal
        });

        $('#casben-subtotal').val(subtotal.toFixed(2));
        $('#casben-discount-total').val(discountTotal.toFixed(2));
        $('#casben-tax-total').val(taxTotal.toFixed(2));
        $('#casben-grand-total').val(grandTotal.toFixed(2));

    }

    function getNextRowIndex() {

        return $('#casben-invoice-items-table tbody tr').length;

    }

    function addInvoiceRow() {

        var index = getNextRowIndex();

        var template = wp.template('casben-invoice-row');

        $('#casben-invoice-items-table tbody').append(
            template({
                index: index
            })
        );

        calculateInvoice();

    }

    function renumberRows() {

        $('#casben-invoice-items-table tbody tr').each(function (index) {

            $(this).find('[name]').each(function () {

                var name = $(this).attr('name');

                name = name.replace(
                    /items\[\d+\]/,
                    'items[' + index + ']'
                );

                $(this).attr('name', name);

            });

        });

    }

    $(document).on(
        'input',
        '.casben-qty, .casben-price, .casben-discount, .casben-tax-rate',
        function () {

            calculateInvoice();

        }
    );

    $(document).on(
        'click',
        '#casben-add-item',
        function (e) {

            e.preventDefault();

            addInvoiceRow();

        }
    );

    $(document).on(
        'click',
        '.casben-remove-row',
        function (e) {

            e.preventDefault();

            var $rows = $('#casben-invoice-items-table tbody tr');

            if ($rows.length <= 1) {

                alert('At least one invoice item is required.');

                return;

            }

            var $row = $(this).closest('tr');

            console.log(
                'Rows BEFORE remove:',
                $('#casben-invoice-items-table tbody tr').length
            );

            $row.remove();

            console.log(
                'Rows AFTER remove:',
                $('#casben-invoice-items-table tbody tr').length
            );

            renumberRows();

            calculateInvoice();

        }
    );

    calculateInvoice();

});