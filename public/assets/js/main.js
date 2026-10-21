/* ==========================================================================
   PT MAKMUR BERSAMA ENJINIRING (MBE) - MAIN JAVASCRIPT
   ========================================================================== */

document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation Toggle
    const mobileToggle = document.getElementById('mobileToggle');
    const navMenu = document.getElementById('navMenu');

    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', function() {
            if (navMenu.style.display === 'flex') {
                navMenu.style.display = 'none';
            } else {
                navMenu.style.display = 'flex';
                navMenu.style.flexDirection = 'column';
                navMenu.style.position = 'absolute';
                navMenu.style.top = '100%';
                navMenu.style.left = '0';
                navMenu.style.width = '100%';
                navMenu.style.background = '#ffffff';
                navMenu.style.padding = '20px';
                navMenu.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
            }
        });
    }

    // Lightbox / Image Modal Preview
    const modalHtml = `
        <div id="imageModal" class="modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.9); z-index:99999; justify-content:center; align-items:center; padding:20px; backdrop-filter:blur(5px);">
            <div style="position:absolute; top:20px; right:30px; display:flex; gap:15px; align-items:center; z-index:100000;">
                <span id="zoomToggleModal" style="color:#fff; font-size:14px; background:rgba(255,255,255,0.2); padding:6px 14px; border-radius:20px; cursor:pointer; font-weight:600; user-select:none;"><i class="fa-solid fa-magnifying-glass-plus"></i> Zoom Full</span>
                <span id="closeModal" style="color:#fff; font-size:36px; cursor:pointer; font-weight:bold; line-height:1; user-select:none;">&times;</span>
            </div>
            <div id="modalImgWrapper" style="max-width:92vw; max-height:90vh; overflow:auto; display:flex; align-items:center; justify-content:center; border-radius:12px; background:#ffffff; box-shadow:0 10px 40px rgba(0,0,0,0.6); padding:10px;">
                <img id="modalImg" src="" style="max-width:88vw; max-height:82vh; object-fit:contain; border-radius:8px; transition:transform 0.3s ease; cursor:zoom-in;">
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);

    const imageModal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');
    const closeModal = document.getElementById('closeModal');
    const zoomToggleModal = document.getElementById('zoomToggleModal');

    let isZoomed = false;

    function toggleZoom() {
        if (!isZoomed) {
            modalImg.style.maxWidth = 'none';
            modalImg.style.maxHeight = 'none';
            modalImg.style.transform = 'scale(1.8)';
            modalImg.style.cursor = 'zoom-out';
            if (zoomToggleModal) zoomToggleModal.innerHTML = '<i class="fa-solid fa-magnifying-glass-minus"></i> Reset Zoom';
            isZoomed = true;
        } else {
            modalImg.style.maxWidth = '88vw';
            modalImg.style.maxHeight = '82vh';
            modalImg.style.transform = 'scale(1)';
            modalImg.style.cursor = 'zoom-in';
            if (zoomToggleModal) zoomToggleModal.innerHTML = '<i class="fa-solid fa-magnifying-glass-plus"></i> Zoom Full';
            isZoomed = false;
        }
    }

    if (modalImg) {
        modalImg.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleZoom();
        });
    }

    if (zoomToggleModal) {
        zoomToggleModal.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleZoom();
        });
    }

    document.addEventListener('click', function(e) {
        const trigger = e.target.closest('.lightbox-trigger');
        if (trigger) {
            e.preventDefault();
            let src = trigger.getAttribute('data-src') || trigger.getAttribute('src') || trigger.getAttribute('href');
            if (!src) {
                const childImg = trigger.querySelector('img');
                if (childImg) {
                    src = childImg.getAttribute('src');
                }
            }
            if (src && imageModal && modalImg) {
                modalImg.src = src;
                isZoomed = false;
                modalImg.style.maxWidth = '88vw';
                modalImg.style.maxHeight = '82vh';
                modalImg.style.transform = 'scale(1)';
                modalImg.style.cursor = 'zoom-in';
                if (zoomToggleModal) zoomToggleModal.innerHTML = '<i class="fa-solid fa-magnifying-glass-plus"></i> Zoom Full';
                imageModal.style.display = 'flex';
            }
        }
    });

    if (closeModal && imageModal) {
        closeModal.addEventListener('click', function() {
            imageModal.style.display = 'none';
        });

        imageModal.addEventListener('click', function(e) {
            if (e.target === imageModal || e.target.id === 'modalImgWrapper') {
                imageModal.style.display = 'none';
            }
        });
    }
});
