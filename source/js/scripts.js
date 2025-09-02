/* globals jQuery, strl_responsive_images, Foundation, strl_vars, FWP, $ */

const hide_alert = strlGetCookie("alertbar"),
  strl_responsive_iframes = function () {
    $("iframe[src*='youtube.com'], iframe[src*='vimeo.com']").each(function () {
      $(this).wrap('<div class="video-container"></div>');
      $(this).parent(".video-container").addClass("active");
    });
  };

function strlSetCookie(cname, cvalue, exdays) {
  // eslint-disable-line
  const d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  let expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function strlGetCookie(cname) {
  // eslint-disable-line
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) === " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function strlAddReadspeaker(client_id) {
  if (client_id.length === 0) {
    return;
  }
  const script = document.createElement("script");
  script.type = "text/javascript";
  script.src =
    "//cdn-eu.readspeaker.com/script/" + client_id + "/webReader/webReader.js";
  script.id = "rs_req_Init";
  document.head.appendChild(script);
}

document.addEventListener("DOMContentLoaded", function () {
  strlAddReadspeaker(4912);

  const detailsElements = document.querySelectorAll("details");

  if (detailsElements) {
    detailsElements.forEach(function (detailsElement) {
      detailsElement.setAttribute("aria-expanded", "false"); // You can set 'false' if you want them to start collapsed
    });
  }

  const searchFields = document.querySelectorAll(
    ".header-home .headersearch input, .header-search .headersearch input, .site-header #headersearch input"
  );
  searchFields.forEach((searchField) => {
    const searchInterval = setInterval(() => {
      if (searchField) {
        const ariaLabel = searchField.getAttribute("data-aria-label");
        if (ariaLabel) {
          searchField.setAttribute("aria-label", ariaLabel);
        }
        clearInterval(searchInterval);
      }
    }, 100);
  });
});
document.addEventListener("facetwp-loaded", function () {
  const facetwpSearchFields = document.querySelectorAll(
    ".facetwp-type-search .facetwp-search"
  );
  facetwpSearchFields.forEach((searchField) => {
    const searchInterval = setInterval(() => {
      if (searchField) {
        const searchLabel = searchField.parentNode.querySelector("label");
        if (searchLabel) {
          searchField.setAttribute("aria-label", searchLabel.textContent);
        }
        clearInterval(searchInterval);
      }
    }, 100);
  });
});

const lastMenuItem = document.querySelector("#menu-main-1 li:last-child");
const menuToggleBtn = document.querySelector(".menutoggle");

function handleTabKeyPress(event) {
  // Check if the pressed key is the tab key (key code 9)
  if (event.keyCode === 9) {
    if (document.activeElement === lastMenuItem.querySelector("a")) {
      menuToggleBtn.click();
    }
  }
}

document.addEventListener("keydown", handleTabKeyPress);

jQuery(($) => {
  $(document).on("click", "details", function () {
    const detailsElement = $(this);
    const currentExpanded = detailsElement.attr("aria-expanded") === "true";

    detailsElement.attr("aria-expanded", (!currentExpanded).toString());
  });

  if ($(".page-template-search-template").length > 0) {
    $(document).on("facetwp-loaded", function () {
      var searchterm = $(".headersearch input").val();

      if (
        searchterm !== "null" &&
        typeof (searchterm !== undefined) &&
        searchterm !== ""
      ) {
        $("section.search").stop().slideDown();
      } else {
        $("section.search").stop().slideUp();
      }
    });
  }

  //If its a single article page add class stretch to sections
  if ($(".single-article-content").length > 0) {
    $("section section > .grid-x").addClass("stretch");
  }
  if ($(".part-of-day").length > 0) {
    // Create a new Date object
    const currentDate = new Date();
    const currentTime = currentDate.getHours();
    const localization = $(".part-of-day").data("localization");
    let message = "";

    // Check the current time and set the message accordingly
    if (currentTime < 12) {
      message = localization.morning;
    } else if (currentTime >= 12 && currentTime <= 18) {
      message = localization.afternoon;
    } else if (currentTime >= 18 && currentTime <= 24) {
      message = localization.evening;
    }

    $(".part-of-day").text(message);
  }

  $(document).on("facetwp-loaded", function () {
    $(".facetwp-checkbox").attr({ role: "checkbox", tabindex: "0" });
    $(".facetwp-checkbox:not(.checked)").attr("aria-checked", "false");
    $(".facetwp-checkbox.checked").attr("aria-checked", "true");
    if ($(".facetwp-checkbox label").length === 0) {
      $(".facetwp-checkbox").wrapInner("<label></label>");
    }

    $(".facetwp-checkbox").each(function () {
      $(this).find("label").attr("for", $(this).data("value"));
      $(this).prepend(
        '<input type="checkbox" id="' +
          $(this).data("value") +
          '" tabindex="-1" value="' +
          $(this).data("value") +
          '">'
      );
    });

    $(".facetwp-checkbox").keypress(function () {
      $(this).click();
    });
  });

  $(document).on("click", ".closealert", function () {
    $(this).closest(".alertbar").addClass("inactive");
    strlSetCookie("alertbar", "hide", 0.5);
  });

  if ("hide" === hide_alert && $(".alertbar").length > 0) {
    $(".alertbar").hide();
  }

  if ("hide" !== hide_alert && $(".alertbar").length > 0) {
    $(".alertbar").show();
  }

  $(document).on("click", ".toggle-btn", function () {
    if ("false" === $(this).attr("aria-expanded")) {
      $(this).attr("aria-expanded", true);
    } else {
      $(this).attr("aria-expanded", false);
    }

    $("." + $(this).data("trigger")).toggleClass("is-active");
  });

  $(document).on("click", ".scrolltop", () => {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
  });

  $(document).on("facetwp-loaded", () => {
    strl_responsive_images();
    $(".facetwp-page")
      .addClass("nofollow noreferrer")
      .attr("href", window.location.href);

    $(document).on("click", ".facetwp-page", function (e) {
      e.preventDefault();
    });
  });

  strl_responsive_iframes();

  $(document).on("click", ".menu-icon", function (e) {
    $("#offCanvas").foundation("toggle", "click", $(this));
    $("body").toggleClass("offcanvas-open");
    if (!$("body").hasClass("offcanvas-triggered")) {
      $("body").addClass("offcanvas-triggered");
    }
    e.stopPropagation();
  });

  // Scroll icon
  var scrolldistancetop = $(window).scrollTop(),
    scrollheight = 40;
  if (scrolldistancetop > scrollheight) {
    $(".scroll-to-top").addClass("visible");
  } else {
    $(".scroll-to-top").removeClass("visible");
  }

  $(window).on("scroll", () => {
    var scrolldistancetop = $(window).scrollTop();
    if (scrolldistancetop > scrollheight) {
      $(".scroll-to-top").addClass("visible");
    } else {
      $(".scroll-to-top").removeClass("visible");
    }
  });

  $(document).on("click", ".scroll-to-top", () => {
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });
  // end:Scroll icon

  $(document).on("facetwp-loaded", () => {
    if (FWP.loaded) {
      if ($(".facetwp-load-more").length === 0) {
        $("html, body").animate(
          {
            scrollTop: $(".facetwp-template").offset().top - 210,
          },
          500
        );
      }
    }
  });

  // A11Y fix for recaptcha
  if ($("div.g-recaptcha").length > 0) {
    grecaptcha.ready(function () {
      $(
        '<label for="g-recaptcha-response-100000">Recaptcha veld</label>'
      ).insertAfter($("#g-recaptcha-response-100000")); // recaptcha fix for missing label field
    });
  }

  $.event.special.touchstart = {
    setup: function (_, ns, handle) {
      this.addEventListener("touchstart", handle, {
        passive: !ns.includes("noPreventDefault"),
      });
    },
  };

  $.event.special.touchmove = {
    setup: function (_, ns, handle) {
      this.addEventListener("touchmove", handle, {
        passive: !ns.includes("noPreventDefault"),
      });
    },
  };
});

document.addEventListener("DOMContentLoaded", () => {
  const publicationSection = document.querySelector(
    "section.publications-overview"
  );

  if (publicationSection) {
    const body = document.body;
    const toggleButton = document.querySelectorAll(".offcanvas-toggler");
    const offCanvasAll = document.querySelectorAll(".offcanvas");

    toggleButton.forEach((button) => {
      const offCanvas = document.querySelector(
        '[data-toggler="' + button.dataset.toggle + '"]'
      );

      // Remove inline display: none to prevent offcanvas showing up on page load
      offCanvas.removeAttribute("style");

      button.addEventListener("click", () => {
        button.classList.toggle("toggle-open");
        body.classList.toggle("offcanvas-open");
        offCanvas.classList.toggle("closed");
        offCanvas.classList.toggle("opened");

        if (button.classList.contains("offcanvas-closer")) {
          moveFocusToOffcanvasClose();
        } else {
          moveFocusToOffcanvas();
        }
        toggleOffCanvasTabbing();
      });
    });

    offCanvasAll.forEach((offCanvas) => {
      // Close submenu's on Esc
      document.addEventListener("keyup", (e) => {
        if ("Escape" === e.key) {
          offCanvas.classList.add("closed");
          offCanvas.classList.remove("opened");
          body.classList.remove("offcanvas-open");
          toggleOffCanvasTabbing();
          moveFocusToOffcanvasClose();
        }
      });

      // Close submenu when focus out of last VISIBLE menu item
      let currFocus = document;
      document.addEventListener("keyup", (e) => {
        if ("Tab" === e.key) {
          const menuItems = offCanvas.querySelectorAll(".menu-item");
          const visibleItems = [];
          menuItems.forEach((item) => {
            if (item.checkVisibility()) {
              visibleItems.push(item);
            }
          });
          if (
            visibleItems.length &&
            currFocus === visibleItems[visibleItems.length - 1] &&
            currFocus !== e.target.closest(".menu-item")
          ) {
            console.log("test 1");
            offCanvas.classList.add("closed");
            offCanvas.classList.remove("opened");
            body.classList.remove("offcanvas-open");
            toggleOffCanvasTabbing();
          }
          currFocus = e.target.closest(".menu-item");
        }
      });
    });

    toggleOffCanvasTabbing();

    function moveFocusToOffcanvas() {
      if (body.classList.contains("offcanvas-open")) {
        const offCanvas = document.querySelector(".offcanvas");
        const firstFocusable = offCanvas.querySelector(
          "button, a, input, select, textarea, .facetwp-checkbox, .facetwp-type-checkboxes, [tabindex]:not([tabindex='-1'])"
        );

        console.log(firstFocusable);
        firstFocusable.focus();
      }
    }

    function moveFocusToOffcanvasClose() {
      if (!body.classList.contains("offcanvas-open")) {
        if (document.querySelector(".filter-open")) {
          document.querySelector(".filter-open").focus();
        }
      }
    }

    function checkFocusLost(e) {
      if (body.classList.contains("offcanvas-open")) {
        const offCanvas = document.querySelector(".offcanvas");
        if (!offCanvas.contains(e.target)) {
          offCanvas.classList.add("closed");
          offCanvas.classList.remove("opened");
          body.classList.remove("offcanvas-open");
          toggleOffCanvasTabbing();
          moveFocusToOffcanvasClose();
        }
      }
    }

    document.addEventListener("focusin", checkFocusLost);

    function toggleOffCanvasTabbing() {
      const links = document.querySelectorAll(
        ".offcanvas button, .offcanvas a, .offcanvas .fa-caret-down, .filter-accordion .filter-title, .facetwp-type-search .facetwp-search, .facetwp-type-checkboxes .facetwp-checkbox, .facetwp-type-checkboxes"
      );

      links.forEach((link) => {
        if (!body.classList.contains("offcanvas-open")) {
          link.setAttribute("tabindex", "-1");
        } else {
          link.setAttribute("tabindex", "0");
        }
      });
    }
  }
});
