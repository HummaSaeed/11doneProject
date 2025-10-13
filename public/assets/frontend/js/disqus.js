'use strict';

var disqus_config = function () {
  this.page.url = baseURL + '/blog/' + slug;
  this.page.identifier = blogId;
};

(function () {
  var d = document, s = d.createElement('script');
  s.src = 'https://bookapp.disqus.com/embed.js';
  s.setAttribute('data-timestamp', +new Date());
  (d.head || d.body).appendChild(s);
})();
