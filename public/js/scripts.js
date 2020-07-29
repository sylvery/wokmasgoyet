// var $collectionHolder;
// var $addTagButton = '<button type="button" class="add_comment_link">Add Comment</button>';
// var $newLinkLi = $('li').append($addTagButton);

$(document).ready(()=>{
    $.datepicker.setDefaults({
        dateFormat: 'd/m/Y'
    })
    $('.date-input').datepicker({
        dateFormat: 'dd/mm/yy',
        format: 'dd/mm/yy',
    });
    // $collectionHolder = $('ul.comments');
    // $collectionHolder.append($newLinkLi);
    // $collectionHolder.data('index', $collectionHolder.find(':input').length);
    // $addTagButton.on('click', function(e){
        // addTagForm($collectionHolder, $newLinkLi);
    // })
})

function addTagForm ($collectionHolder, $newLinkLi) {
    var prototype = $collectionHolder.dataset.prototype;
    var index = $collectionHolder.dataset.index;
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index+1);
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}