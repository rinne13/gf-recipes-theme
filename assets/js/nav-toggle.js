document.addEventListener("DOMContentLoaded", function () {
  const btn = document.querySelector(".nav-toggle");
  const nav = document.querySelector(".main-navigation");
  if (!btn || !nav) return;

  btn.addEventListener("click", () => {
    const expanded = btn.getAttribute("aria-expanded") === "true";
    btn.setAttribute("aria-expanded", String(!expanded));
    document.body.classList.toggle("nav-open", !expanded);
  });
});
