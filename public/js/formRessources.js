var $collectionHolder;

var formRessources = '<label for="url">Url : </label><input type="text" id ="url" name="url">';

// setup an "add a Ressources" link
var $addRessourcesButton = $('<button type="button" class="add_ressources_link">Add ressources</button>');
var $newLinkLi = $('<li></li>').append($addRessourcesButton);



jQuery(document).ready(function() {
    // Get the ul that holds the collection of Ressources
    $collectionHolder = $('ul.ressources');

    // add the "add a Ressources" anchor and li to the Ressources ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('li').length);

    $addRessourcesButton.on('click', function(e) {
        // add a new Ressources form (see next code block)
        addRessourcesForm($collectionHolder, $newLinkLi);
    });
});

function addRessourcesForm($collectionHolder, $newLinkLi) {

    
    // Get the data-prototype explained earlier
    //var prototype = $collectionHolder.data('prototype');
    var collection = document.querySelector('ul.ressources');
    var div = document.querySelector('div#document_ressources');
console.log(div);
    var prototype = div.dataset.prototype;

    // get the new index
    var index = collection.dataset.index;

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);
console.log(newForm);
    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);
    
    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}