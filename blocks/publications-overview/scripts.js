document.addEventListener("facetwp-loaded", () => {
  const qs = FWP.buildQueryString();
  const resetFilters = document.querySelectorAll(".reset-filters");
  const currentFilter = document.querySelectorAll(".filter-current");

  if (currentFilter && resetFilters) {
    if ("" === qs) {
      // no facets are selected
      resetFilters.forEach((elem) => {
        elem.style.display = "none";
      });
      currentFilter.forEach((elem) => {
        elem.style.display = "none";
      });
    } else {
      resetFilters.forEach((elem) => {
        elem.style.display = "flex";
      });
      currentFilter.forEach((elem) => {
        elem.style.display = "flex";
      });
    }
  }
});

const filterTitles = document.querySelectorAll(".filter-title");
filterTitles.forEach((filterTitle) => {
  filterTitle.addEventListener("click", (elem) => {
    elem.target.parentNode.classList.toggle("open");
  });
});

function rebuildPagination() {
  const paginationWrappers = document.querySelectorAll(".pagination");

  if (paginationWrappers) {
    paginationWrappers.forEach((pagination) => {
      const totalPages = FWP.settings.pager.total_pages;
      const currentPage = FWP.settings.pager.page;
      const translatePage = strl_vars.translate_page;

      if (totalPages > 1) {
        const facetPageWrapper = pagination.querySelector(".facetwp-pager");
				if (facetPageWrapper) {
        const pages = facetPageWrapper.querySelectorAll(
          "a:not(.prev):not(.next)"
        );

        const prevPage = facetPageWrapper.querySelector(".prev");
        const nextPage = facetPageWrapper.querySelector(".next");

        const fraction = facetPageWrapper.querySelector(".page-total");
        let fractionHTML;

        if (!fraction) {
          fractionHTML = document.createElement("span");
          fractionHTML.classList.add("page-total");
          fractionHTML.innerHTML =
            translatePage + " " + currentPage + " / " + totalPages;
        } else {
          fractionHTML = fraction;
        }

        pagination.style.display = "flex";

        if (prevPage) {
          prevPage.style.display = "flex";
        }

        if (nextPage) {
          nextPage.style.display = "flex";
        }

        if (Foundation.MediaQuery.current === "small") {
          pages.forEach((page) => {
            page.style.display = "none";
          });
          if (currentPage === 1 && facetPageWrapper) {
            facetPageWrapper.insertBefore(fractionHTML, nextPage);
          } else if (!fraction && facetPageWrapper) {
            facetPageWrapper.insertBefore(
              fractionHTML,
              prevPage.nextElementSibling
            );
          }
        } else {
          pages.forEach((page) => {
            page.style.display = "flex";
          });
          if (fraction) {
            fraction.remove();
          }
        }
				}
      } else {
        pagination.style.display = "block";
      }
    });
  }
}

document.addEventListener("facetwp-loaded", () => {
  rebuildPagination();
});

window.addEventListener("resize", () => {
  rebuildPagination();
});
