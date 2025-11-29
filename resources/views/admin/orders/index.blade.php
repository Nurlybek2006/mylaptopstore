<!DOCTYPE html>
<html lang="kk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тапсырыстарды Басқару - Laptop.KZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-sidebar {
            background: #1f2937;
            color: white;
            min-height: 100vh;
            padding: 0;
        }

        .admin-sidebar .nav-link {
            color: #d1d5db;
            padding: 1rem 1.5rem;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: white;
            background: #374151;
            border-left-color: #3b82f6;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .bg-orders {
            background: #dbeafe;
            color: #2563eb;
        }

        .bg-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .bg-completed {
            background: #dcfce7;
            color: #16a34a;
        }

        .bg-requests {
            background: #fce7f3;
            color: #db2777;
        }

        .table-actions {
            white-space: nowrap;
        }

        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status-processing {
            background: #dbeafe;
            color: #2563eb;
        }

        .status-completed {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-cancelled {
            background: #fecaca;
            color: #dc2626;
        }

        .status-new {
            background: #fef3c7;
            color: #d97706;
        }

        .tab-content {
            border: 1px solid #dee2e6;
            border-top: none;
            padding: 1.5rem;
            border-radius: 0 0 0.375rem 0.375rem;
        }

        .nav-tabs .nav-link.active {
            background: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            font-weight: 600;
        }

        .form-select-sm {
            width: auto;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Админ sidebar -->
            <div class="col-lg-2 admin-sidebar">
                <div class="p-3">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-laptop me-2"></i>Админ
                    </h4>
                </div>

                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Басты бет
                    </a>
                    <a class="nav-link" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-laptop me-2"></i>Өнімдер
                    </a>
                    <a class="nav-link active" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-bag me-2"></i>Тапсырыстар
                    </a>
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-2"></i>Пайдаланушылар
                    </a>
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fas fa-home me-2"></i>Сайтқа өту
                    </a>
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>Шығу
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </nav>
            </div>

            <!-- Негізгі контент -->
            <div class="col-lg-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Тапсырыстарды Басқару</h2>
                </div>

                <!-- Хабарламаларды көрсету -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Статистика -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-orders">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h3>{{ $stats['total_orders'] }}</h3>
                            <p class="text-muted mb-0">Барлық тапсырыстар</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-pending">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3>{{ $stats['pending_orders'] }}</h3>
                            <p class="text-muted mb-0">Күтілуде</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-completed">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h3>{{ $stats['completed_orders'] }}</h3>
                            <p class="text-muted mb-0">Аяқталған</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-requests">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <h3>{{ $stats['total_requests'] }}</h3>
                            <p class="text-muted mb-0">Ноутбук сұраныстары</p>
                        </div>
                    </div>
                </div>

                <!-- Табтар -->
                <ul class="nav nav-tabs" id="ordersTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab === 'orders' ? 'active' : '' }}" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">
                            <i class="fas fa-shopping-bag me-2"></i>Тапсырыстар
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $tab === 'requests' ? 'active' : '' }}" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requests" type="button" role="tab">
                            <i class="fas fa-laptop me-2"></i>Ноутбук Сұраныстары
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="ordersTabsContent">
                    <!-- Тапсырыстар табы -->
                    <div class="tab-pane fade {{ $tab === 'orders' ? 'show active' : '' }}" id="orders" role="tabpanel">
                        @if ($orders->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Тапсырыстар табылмады
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Пайдаланушы</th>
                                        <th>Жиынтық сома</th>
                                        <th>Статус</th>
                                        <th>Өнімдер</th>
                                        <th>Құрылған күні</th>
                                        <th>Әрекет</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td><strong>#{{ $order->id }}</strong></td>
                                        <td>
                                            <div>
                                                <strong>{{ $order->user->name ?? 'Пайдаланушы жоқ' }}</strong>
                                                <div class="text-muted small">{{ $order->user->email ?? 'Email жоқ' }}</div>
                                                @if($order->user && $order->user->phone)
                                                <div class="text-muted small">{{ $order->user->phone }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $order->formatted_total }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Күтілуде</option>
                                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Өңделуде</option>
                                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Аяқталған</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Бас тартылған</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $order->items_count }} өнім</span>
                                            @if($order->items_count > 0)
                                            <button class="btn btn-sm btn-outline-info ms-2"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#orderDetails{{ $order->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        <td class="table-actions">
                                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Тапсырысты шынымен өшірейін бе?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Тапсырыс элементтері -->
                                    @if($order->items_count > 0)
                                    <tr>
                                        <td colspan="7" class="p-0">
                                            <div class="collapse" id="orderDetails{{ $order->id }}">
                                                <div class="order-details">
                                                    <h6>Тапсырыс элементтері:</h6>
                                                    @foreach($order->items as $item)
                                                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                                        <div>
                                                            <strong>{{ $item->product->name ?? 'Өнім жоқ' }}</strong>
                                                            <div class="text-muted small">
                                                                Саны: {{ $item->quantity }} × {{ $item->formatted_price }}
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <strong>{{ $item->formatted_total }}</strong>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>

                    <!-- Ноутбук сұраныстары табы -->
                    <div class="tab-pane fade {{ $tab === 'requests' ? 'show active' : '' }}" id="requests" role="tabpanel">
                        @if ($laptop_requests->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Ноутбук сұраныстары табылмады
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Аты</th>
                                        <th>Байланыс</th>
                                        <th>Бюджет</th>
                                        <th>Мақсаты</th>
                                        <th>Статус</th>
                                        <th>Құрылған күні</th>
                                        <th>Әрекет</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($laptop_requests as $request)
                                    <tr>
                                        <td><strong>#{{ $request->id }}</strong></td>
                                        <td>
                                            <strong>{{ $request->name }}</strong>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <div><i class="fas fa-envelope me-1"></i>{{ $request->email }}</div>
                                                @if($request->phone)
                                                <div><i class="fas fa-phone me-1"></i>{{ $request->phone }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($request->budget)
                                            {{ $request->formatted_budget }}
                                            @else
                                            <span class="text-muted">Көрсетілмеген</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small">
                                                {{ Str::limit($request->purpose, 100) }}
                                            </div>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.requests.update-status', $request->id) }}" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="new" {{ $request->status == 'new' ? 'selected' : '' }}>Жаңа</option>
                                                    <option value="processing" {{ $request->status == 'processing' ? 'selected' : '' }}>Өңделуде</option>
                                                    <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Аяқталған</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>{{ $request->created_at->format('d.m.Y H:i') }}</td>
                                        <td class="table-actions">
                                            <button class="btn btn-sm btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#requestModal{{ $request->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <form action="{{ route('admin.requests.destroy', $request->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Сұранысты шынымен өшірейін бе?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Сұраныс модалды терезесі -->
                                    <div class="modal fade" id="requestModal{{ $request->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Ноутбук сұранысы #{{ $request->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Пайдаланушы ақпараты:</h6>
                                                            <p><strong>Аты:</strong> {{ $request->name }}</p>
                                                            <p><strong>Email:</strong> {{ $request->email }}</p>
                                                            @if($request->phone)
                                                            <p><strong>Телефон:</strong> {{ $request->phone }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Сұраныс ақпараты:</h6>
                                                            @if($request->budget)
                                                            <p><strong>Бюджет:</strong> {{ $request->formatted_budget }}</p>
                                                            @endif
                                                            <p><strong>Статус:</strong>
                                                                <span class="status-badge status-{{ $request->status }}">
                                                                    {{ $request->status_label }}
                                                                </span>
                                                            </p>
                                                            <p><strong>Құрылған күні:</strong> {{ $request->created_at->format('d.m.Y H:i') }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        <h6>Ноутбук мақсаты:</h6>
                                                        <div class="border rounded p-3 bg-light">
                                                            {{ nl2br($request->purpose) }}
                                                        </div>
                                                    </div>

                                                    @if($request->specifications)
                                                    <div class="mt-3">
                                                        <h6>Қосымша талаптар:</h6>
                                                        <div class="border rounded p-3 bg-light">
                                                            {{ nl2br($request->specifications) }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Жабу</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Табтарды басқару
        document.addEventListener('DOMContentLoaded', function() {
            // URL параметрлеріне қарай табты сақтау
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');

            if (tab) {
                // Табты көрсету
                const tabElement = document.getElementById(tab + '-tab');
                if (tabElement) {
                    const tab = new bootstrap.Tab(tabElement);
                    tab.show();
                }
            }
        });
    </script>
</body>

</html>