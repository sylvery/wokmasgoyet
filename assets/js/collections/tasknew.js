import $ from 'jquery';


var $collectionHolder;

// setup an "add a task milestone" link
var $addTaskMilestoneButton = $('<button type="button" class="add_task_milestone btn btn-primary">Add a Milestone</button>');
var $newLinkLi = $('<div class="col-12 my-3"></div>').append($addTaskMilestoneButton);

$(document).ready(function() {
    // Get the ul that holds the collection of task milestones
    $collectionHolder = $('div#taskMilestones');

    // add the "add a tag" anchor and li to the task milestones ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTaskMilestoneButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTaskMilestoneForm($collectionHolder, $newLinkLi);
    });
});

function addTaskMilestoneForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div class="col-12"></div>').append(newForm);
    $newLinkLi.before($newFormLi);
}