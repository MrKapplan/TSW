Handlebars.registerHelper('if_eq', function(a, b, opts) {
  if (a == b)
    return opts.fn(this);
  else
    return opts.inverse(this);
});


//module.exports.register = function( Handlebars, options, params ) {

  Handlebars.registerHelper( 'arraylength', function( array ) {
    return array.length;
  } );

