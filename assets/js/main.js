/* Starter Theme front-end behaviour. Vanilla JS, no dependencies.
   When porting a reference site, add its scripts as new files and enqueue them in inc/enqueue.php. */
(() => {
  "use strict";
  document.documentElement.classList.add("js");
  const reduced = matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* Header hides on scroll down, returns on scroll up */
  const header = document.querySelector("[data-header]");
  let last = scrollY;
  addEventListener("scroll", () => {
    const y = scrollY;
    if (header) header.classList.toggle("is-hidden", y > 160 && y > last && !document.body.classList.contains("nav-open"));
    last = y;
  }, { passive: true });

  /* Mobile menu */
  const toggle = document.querySelector("[data-nav-toggle]");
  const nav = document.querySelector("[data-nav]");
  if (toggle && nav) {
    toggle.addEventListener("click", () => {
      const open = toggle.getAttribute("aria-expanded") !== "true";
      toggle.setAttribute("aria-expanded", String(open));
      nav.classList.toggle("is-open", open);
      document.body.classList.toggle("nav-open", open);
    });
    addEventListener("keydown", (e) => { if (e.key === "Escape" && nav.classList.contains("is-open")) toggle.click(); });
  }

  /* Reveal on scroll */
  const items = document.querySelectorAll("[data-reveal]");
  if (reduced || !("IntersectionObserver" in window)) {
    items.forEach((el) => el.classList.add("is-in"));
  } else {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => { if (e.isIntersecting) { e.target.classList.add("is-in"); io.unobserve(e.target); } });
    }, { rootMargin: "0px 0px -12% 0px" });
    items.forEach((el) => io.observe(el));
  }
})();
