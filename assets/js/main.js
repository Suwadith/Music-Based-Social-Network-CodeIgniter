// $(document).ready(function () {
//     var contact = new Contact({ emailAddress: "suwadith06@gmail.com"});
//
//     var contactItemView = new ContactItemView({model: contact});
//     $("#contactTitle").append(contactItemView.render().$el);
// });

$(document).ready(function () {
    var contacts = new Contacts([
        new Contact({emailAddress: "suwadith06@gmail.com"}),
        new Contact({emailAddress: "srithar.2015214@iit.ac.lk"}),
        new Contact({emailAddress: "w1608451@my.westminster.ac.uk"})
    ]);

    var contactItemsView = new ContactItemsView({model: contacts});
    $("#contactTitle").append(contactItemsView.render().$el);
});

console.log("in");