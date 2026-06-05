<!--modal-->
<div class="modal fade" id="tc_modal">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title fw-bold">BenHub: Terms and Conditions</div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="text-start mb-4">Below are our detailed, but not limited, terms and conditions, which also include our privacy policy. Please read these before making a reservation. If you have any further questions or requests, please don't hesitate to contact us. In addition, when making a reservation, an email address is required because that will be used for our confirmation email.</p>
        <div id="modal_tc_descriptions">
          Loading terms...
        </div>
      </div>
      <div class="modal-footer">
        <p>BenHub Management</p>
      </div>
    </div>
  </div>
</div>

<script>
  function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    }[char]));
  }

  // Load terms when modal is shown or just asynchronously
  document.addEventListener("DOMContentLoaded", function() {
    fetch('/api/terms')
      .then(response => response.json())
      .then(res => {
        if (res.status === 'success') {
          let html = '';
          res.data.forEach(term => {
            const num = Number(term.tc_num);
            const title = escapeHtml(term.tc_title);
            const desc = escapeHtml(term.tc_description);
            html += `
              <div class="mb-4">
                <h6 class="fw-bold">${num}. ${title}</h6>
                <p class="text-secondary">${desc}</p>
              </div>`;
          });
          document.getElementById('modal_tc_descriptions').innerHTML = html;
        }
      });
  });
</script>
