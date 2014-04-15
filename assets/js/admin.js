jQuery(function($){
  FilamentPlugin = {
    selectors: {
      wrapper: '#filament',
      expanders: '.expander',
      expandables: '.expandable'
    },
    setupExpandables: function(){
      var self = this;

      $(self.selectors.wrapper)
      .on('click', self.selectors.expanders, function(event){
        var toggler = $(this);
        var toggle = $(this).data('toggler-for');
        var toggleElem = $('#' + toggle);
        if(toggleElem.is(':visible')){
          toggler.removeClass('opened');
          console.log(toggleElem.is(':visible'));
        }else{
          toggler.addClass('opened');
          console.log(toggleElem.is(':visible'));
        }
        toggleElem.slideToggle(125);
      });

      // Setup as closed
      $(self.selectors.expandables).hide();

    },
    initialize: function(){
      this.setupExpandables();
    }
  };
  FilamentPlugin.initialize();
  window.FilamentPlugin = FilamentPlugin;
});
