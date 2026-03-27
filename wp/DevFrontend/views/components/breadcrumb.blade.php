<nav aria-label="breadcrumb" class="container">
    <div class="d-flex align-items-center flex-nowrap">
        <a href="/" class="text-secondary me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house"
                viewBox="0 0 16 16">
                <path
                    d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
            </svg>
        </a>

        <span class="text-muted me-2">/</span>

        <div class="dropdown me-2">
            <a class="text-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-view-list" viewBox="0 0 16 16">
                    <path
                        d="M3 4.5h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2m0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1zM1 2a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 2m0 12a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 14" />
                </svg>
            </a>
            <ul class="dropdown-menu shadow-sm border-0">
                <li>
                    <h6 class="dropdown-header">Di chuyển nhanh</h6>
                </li>
                <li><a class="dropdown-item" href="/danh-muc/thung-rac">Thùng rác</a></li>
                <li><a class="dropdown-item" href="/danh-muc/xe-gom-rac">Xe gom rác</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/fe">Về trang chủ</a></li>
            </ul>
        </div>

        <span class="text-muted me-2">/</span>

        <span class="text-dark fw-bold text-truncate">
            Tên trang đích cực kỳ dài của bạn ở đây d asd asd asdas dá đá á
        </span>

    </div>
</nav>

<style>
    .breadcrumb-container {
        display: flex;
        align-items: center;
        white-space: nowrap;
        /* Ép chết trên 1 dòng */
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .current-page {
        max-width: 200px;
        /* Giới hạn độ rộng cấp cuối */
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
