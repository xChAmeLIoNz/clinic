const qrcodeModal = document.getElementById('qrcodeModal');
      console.log("qrcodeModal " + qrcodeModal);
      qrcodeModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const aLink = event.relatedTarget;
        console.log("aLink " +aLink);
        // Extract info from data-bs-* attributes
        const imgBig = aLink.getAttribute('data-bs-imgBig');
        const imgDescription = aLink.getAttribute('data-bs-imgDescription');
        console.log("imgBig " + imgBig); 
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const modalTitle = qrcodeModal.querySelector('.modal-title');
        const modalBodyImg = qrcodeModal.querySelector('.modal-body img');
        modalBodyImg.setAttribute('src', imgBig);
        modalTitle.textContent = imgDescription; // ` ALT 96
      });