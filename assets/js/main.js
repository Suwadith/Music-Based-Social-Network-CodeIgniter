// $(document).ready(function () {
//     var contact = new Contact({ emailAddress: "suwadith06@gmail.com"});
//
//     var contactItemView = new ContactItemView({model: contact});
//     $("#contactTitle").append(contactItemView.render().$el);
// });

$(document).ready(function () {
    // var contacts = new Contacts([
    //     new Contact({id: 1, emailAddress: "suwadith06@gmail.com"}),
    //     new Contact({id: 2, emailAddress: "srithar.2015214@iit.ac.lk"}),
    //     new Contact({id: 3, emailAddress: "w1608451@my.westminster.ac.uk"})
    // ]);

    var contacts = new Contacts();
    // contacts.fetch(
    // //     {
    // //     success: function () {
    // //         // To get all contacts on load
    // //         var contactItemsView = new ContactItemsView({model: contacts});
    // //         $("#contactTitle").append(contactItemsView.render().$el);
    // //     }
    // // }
    // );

    var contactItemsView = new ContactItemsView({model: contacts});
    $("#searchData").append(contactItemsView.render().$el);
});

console.log("in");