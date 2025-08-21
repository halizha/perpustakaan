<button class="btn btn-primary d-md-none menu-toggle">☰</button>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group align-items-center">
            <span class="me-2 d-flex align-items-center text-dark fw-bold">
                <i class="bi bi-person-circle me-1"></i>
                {{ auth()->user()->nama }}
            </span>
        </div>
    </div>
</div>
