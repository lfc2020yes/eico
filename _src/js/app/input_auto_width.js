$(function () {


    width_auto_input();


    var $input = $('.js-input-width-auto'),
        $buffer = $('.input-buffer');

    $input.on('input', function () {
        $buffer.text($input.val());
        $input.width($buffer.width());
    });

});

function width_auto_input()
{
    $('.js-input-width-auto').each(function(i,elem)
    {
        $(this).after('<div class="input-buffer"></div>');

    });
}