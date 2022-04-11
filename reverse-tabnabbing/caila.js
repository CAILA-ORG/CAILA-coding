class CAILA {
  constructor({ whitelistedDomains = [] }) {
    this.whitelistedDomains = whitelistedDomains;
  }
  protect() {
    let anchorTags = document.querySelectorAll('a[target=_blank]');

    for (let i = 0; i < anchorTags.length; i++) {
      /* only edit below this line */

      // get hostname so we can compare later in the blacklisted domains
      let hostname = anchorTags[i].hostname;

      anchorTags[i].setAttribute('rel', 'noopener nofollow noreferrer');

      /* only edit above this line*/
    }

    return anchorTags;
  }
}
