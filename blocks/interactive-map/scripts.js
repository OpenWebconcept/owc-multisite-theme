function strlFacetwpTogglesToButtons() {
  const facetwpToggles = document.querySelectorAll(".facetwp-toggle");

  facetwpToggles.forEach((toggle, index) => {
    const ariaLabel = toggle.getAttribute("aria-label");
    const toggleText = toggle.innerHTML;
    const button = document.createElement("button");
    const classes = toggle.classList;
    button.innerHTML = toggleText;
    button.setAttribute("role", "link");
    button.setAttribute("aria-label", ariaLabel);
    button.setAttribute("tabindex", "0");

    classes.forEach((cls) => {
      button.classList.add(cls);
    });

    toggle.parentElement.appendChild(button);
    toggle.remove();
  });
}

function strlFacetwpCheckboxDepthToggles() {
  const checkboxes = document.querySelectorAll(".facetwp-checkbox");
  checkboxes.forEach((checkbox) => {
    // Only wrap items with children
    const nextSibling = checkbox.nextSibling;
    if (nextSibling) {
      if (!nextSibling.classList.contains("facetwp-depth")) {
        return;
      }
    } else {
      return;
    }

    const html = checkbox.outerHTML;
    checkbox.outerHTML =
      '<span class="flex-wrapper">' +
      html +
      '<button class="custom-depth-toggle"><i class="fa-solid fa-caret-down"></i></button></span>';
  });

  const toggles = document.querySelectorAll(".custom-depth-toggle");
  toggles.forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      toggle.closest(".flex-wrapper").nextSibling.classList.toggle("visible");
      toggle.classList.toggle("active");
    });
  });
}

document.addEventListener("facetwp-loaded", function () {
  FWP.hooks.addAction(
    "facetwp/loaded",
    function () {
      strlFacetwpTogglesToButtons();
      strlFacetwpCheckboxDepthToggles();
    },
    999
  );
});

document.addEventListener("DOMContentLoaded", function () {
  const map = document.querySelector(".interactive-map");
  if (map) {
    FWP.hooks.addAction("facetwp_map/marker/click", function (marker) {
      const id = marker.post_id;
      setTimeout(() => {
        const active_partial = document.querySelector(
          '.location-marker-card[data-id="' + id + '"]'
        );

        if (active_partial) {
          const button = active_partial
            .closest('div[role="dialog"]')
            .querySelector("button");

          if (button) {
            button.focus();
          }
        }
      }, 100);
    });
  }
});
