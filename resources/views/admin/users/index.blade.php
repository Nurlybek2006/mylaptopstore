<!DOCTYPE html>
<html lang="kk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пайдаланушыларды Басқару - Laptop.KZ</title>
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

        .bg-total {
            background: #dbeafe;
            color: #2563eb;
        }

        .bg-admins {
            background: #fef3c7;
            color: #d97706;
        }

        .bg-users {
            background: #dcfce7;
            color: #16a34a;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .role-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .role-admin {
            background: #fef3c7;
            color: #d97706;
        }

        .role-user {
            background: #dcfce7;
            color: #16a34a;
        }

        .table-actions {
            white-space: nowrap;
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
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-bag me-2"></i>Тапсырыстар
                    </a>
                    <a class="nav-link active" href="{{ route('admin.users.index') }}">
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
                    <h2>Пайдаланушыларды Басқару</h2>
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
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-total">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>{{ $stats['total_users'] }}</h3>
                            <p class="text-muted mb-0">Барлық пайдаланушылар</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-admins">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h3>{{ $stats['admin_count'] }}</h3>
                            <p class="text-muted mb-0">Админдер</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon bg-users">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3>{{ $stats['user_count'] }}</h3>
                            <p class="text-muted mb-0">Қарапайым пайдаланушылар</p>
                        </div>
                    </div>
                </div>

                <!-- Пайдаланушылар кестесі -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Барлық пайдаланушылар ({{ $stats['total_users'] }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($users->isEmpty())
                        <p class="text-muted">Пайдаланушылар табылмады</p>
                        @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Пайдаланушы</th>
                                        <th>Email</th>
                                        <th>Телефон</th>
                                        <th>Рөлі</th>
                                        <th>Тапсырыстар</th>
                                        <th>Өнімдер</th>
                                        <th>Тіркелген</th>
                                        <th>Әрекет</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3">
                                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                    @if ($user->id == auth()->id())
                                                    <span class="badge bg-primary ms-1">Сіз</span>
                                                    @endif
                                                    <div class="text-muted small">@{{ $user->username }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? 'Көрсетілмеген' }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.users.update-role', $user->id) }}" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="role" class="form-select form-select-sm"
                                                    onchange="this.form.submit()"
                                                    {{ $user->id == auth()->id() ? 'disabled' : '' }}>
                                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пайдаланушы</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Админ</option>
                                                    <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Модератор</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $user->orders_count }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $user->products_count }}</span>
                                        </td>
                                        <td>
                                            {{ $user->created_at->format('d.m.Y') }}
                                        </td>
                                        <td class="table-actions">
                                            @if ($user->id != auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Пайдаланушыны шынымен өшірейін бе? Бұл әрекетті кері қайтару мүмкін емес.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @else
                                            <span class="text-muted">Өз есебіңіз</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Ақпараттық блок -->
                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-info-circle me-2"></i>Ақпарат</h6>
                    <ul class="mb-0">
                        <li>Өз рөліңізді өзгерте алмайсыз</li>
                        <li>Өз есебіңізді өшіре алмайсыз</li>
                        <li>Пайдаланушыны өшіргенде, оның себеті де тазаланады</li>
                        <li>Админ рөлі бар пайдаланушылар барлық функцияларға қол жеткізе алады</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>