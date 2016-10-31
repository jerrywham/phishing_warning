// Phishing warning
  var locationParams = {};
  if (window.location.search.length > 1) {
    for (var aItKey, nKeyId = 0, aCouples = window.location.search.substr(1).split("&"); nKeyId < aCouples.length; nKeyId++) {
      aItKey = aCouples[nKeyId].split("=");
      locationParams[unescape(aItKey[0])] = aItKey.length > 1 ? unescape(aItKey[1]) : "";
    }
  }

  var article = document.querySelector("div.link-description")
  var content = article.innerHTML;

  var msg = "";
  if (typeof locationParams.referrer !== "undefined") {
    msg = "(" +locationParams.referrer+")";

    // escape
    msg = msg.replace(/<style([\s\S]*?)<\/style>/gi, '');
    msg = msg.replace(/<script([\s\S]*?)<\/script>/gi, '');
    msg = msg.replace(/<\/div>/ig, '\n');
    msg = msg.replace(/<\/li>/ig, '\n');
    msg = msg.replace(/<li>/ig, '  *  ');
    msg = msg.replace(/<\/ul>/ig, '\n');
    msg = msg.replace(/<\/p>/ig, '\n');
    msg = msg.replace(/<br\s*[\/]?>/gi, "\n");
    msg = msg.replace(/<[^>]+>/ig, '');
  }

  article.innerHTML = content.replace("{{referrer}}", msg);
