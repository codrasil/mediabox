<link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.2.45/css/materialdesignicons.min.css">
<style>
  .modal-window {
    opacity: 0;
    perspective: 1000px;
    pointer-events: none;
    transition: visibility 0.1s ease-in;
    visibility: hidden;
  }

  .modal-window:target {
    opacity: 1;
    pointer-events: auto;
    visibility: visible;
  }

  .modal-window .modal {
    margin-left: auto;
    margin-right: auto;
    margin-top: -20rem;
    max-width: 430px;
    transform: scale(0.9);
    transition: all 0.05s cubic-bezier(0,.25,.4,.92);
  }

  .modal-window:target .modal {
    margin-top: 0;
    transform: scale(1);
  }
</style>
