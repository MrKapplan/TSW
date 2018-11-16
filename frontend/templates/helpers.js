Handlebars.registerHelper('if_eq', function(a, b, opts) {
  if (a == b)
    return opts.fn(this);
  else
    return opts.inverse(this);
});



Handlebars.registerHelper('if_max', function(a, b, opts) {
  if (a > b)
    return opts.fn(this);
  else
    return opts.inverse(this);
});

Handlebars.registerHelper('if_less', function(a, b, opts) {
  if (a < b)
    return opts.fn(this);
  else
    return opts.inverse(this);
});