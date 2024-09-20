document.addEventListener("DOMContentLoaded", function () {
    const thumbnail = document.getElementById("thumbnail");
    const popupContainer = document.getElementById("popupContainer");
    const popupImage = document.getElementById("popupImage");
    const closeBtn = document.getElementById("closeBtn");

    // Ketika thumbnail diklik, tampilkan popup dengan gambar yang sesuai
    thumbnail.addEventListener("click", () => {
        popupImage.src = thumbnail.src; // Set gambar popup sama dengan src thumbnail
        popupContainer.style.display = "flex"; // Tampilkan popup
    });

    // Ketika tombol close diklik, sembunyikan popup
    closeBtn.addEventListener("click", () => {
        popupContainer.style.display = "none";
    });

    // Ketika area luar gambar diklik, popup juga akan ditutup
    popupContainer.addEventListener("click", (e) => {
        if (e.target === popupContainer) {
            popupContainer.style.display = "none";
        }
    });
});
