var Contact = Backbone.Model.extend({
    validate: function (attrs) {
        if(!attrs.emailAddress){
            return "Email Address is required.";
        }
    }
});