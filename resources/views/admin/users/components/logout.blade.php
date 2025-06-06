<div class="modal modal-xl fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="logoutModalLabel">Login History</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body">
            <table class="table">
              <thead>
                  <tr>
                      <th>IP Address</th>
                      <th>Device</th>
                      <th>Last Active</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody id="loginHistoryTable"></tbody>
          </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="logout_all_session_btn" onclick="">Logout All</button>

          </div>
      </div>
    </div>
  </div>