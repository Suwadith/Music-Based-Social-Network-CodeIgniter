var ContactItemsView = Backbone.View.extend({
    tagName: "ul",
    id: "contactItems",

    initialize: function(options) {
        if(!(options && options.model)){
            throw new Error("model is not specified.");
        }
    },

   render: function () {

       var self = this;

       this.model.each(function (contact) {
           var view = new ContactItemView({model: contact});
           self.$el.append(view.render().$el);
       });

       return this;
   } 
});