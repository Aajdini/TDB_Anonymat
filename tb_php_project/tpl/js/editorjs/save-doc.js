saveButton.addEventListener('click', function () {

    editor.save().then((outputData) => {
        console.log('Article data: ', outputData)
}).catch((error) => {
        console.log('Saving failed: ', error)
});


});