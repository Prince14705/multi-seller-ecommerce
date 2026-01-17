@extends('admin.dashboard')
@section('title', 'Payment Settings')

@section('content')
<div class="container-fluid pt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-credit-card"></i> Payment Settings</h1>
            <p class="text-muted mb-0">Configure payment gateways and transaction settings</p>
        </div>
        <button class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
    </div>

    <div class="row">
        <!-- Payment Methods -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-wallet"></i> Payment Methods</h6>
                </div>
                <div class="card-body">
                    <!-- Stripe -->
                    <div class="payment-method mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/40" class="me-3" alt="Stripe">
                                <div>
                                    <h6 class="mb-0">Stripe</h6>
                                    <small class="text-muted">Credit card payments</small>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="stripeToggle" checked>
                                <label class="form-check-label" for="stripeToggle"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Publishable Key</label>
                                    <input type="text" class="form-control" value="pk_test_51Example...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Secret Key</label>
                                    <input type="password" class="form-control" value="sk_test_51Example...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PayPal -->
                    <div class="payment-method mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/40" class="me-3" alt="PayPal">
                                <div>
                                    <h6 class="mb-0">PayPal</h6>
                                    <small class="text-muted">PayPal and credit cards</small>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="paypalToggle" checked>
                                <label class="form-check-label" for="paypalToggle"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Client ID</label>
                                    <input type="text" class="form-control" value="AeAExample...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Client Secret</label>
                                    <input type="password" class="form-control" value="ECExample...">
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="paypalSandbox" checked>
                            <label class="form-check-label" for="paypalSandbox">Enable Sandbox Mode</label>
                        </div>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="payment-method mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/40" class="me-3" alt="Bank Transfer">
                                <div>
                                    <h6 class="mb-0">Bank Transfer</h6>
                                    <small class="text-muted">Direct bank transfers</small>
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="bankTransferToggle">
                                <label class="form-check-label" for="bankTransferToggle"></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bank Account Details</label>
                            <textarea class="form-control" rows="4" placeholder="Enter bank account information for customers"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Sidebar -->
        <div class="col-lg-4 mb-4">
            <!-- Currency Settings -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-money-bill-wave"></i> Currency Settings</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Default Currency</label>
                        <select class="form-select">
                            <option value="USD" selected>US Dollar (USD)</option>
                            <option value="EUR">Euro (EUR)</option>
                            <option value="GBP">British Pound (GBP)</option>
                            <option value="JPY">Japanese Yen (JPY)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Currency Position</label>
                        <select class="form-select">
                            <option value="left" selected>Left ($100)</option>
                            <option value="right">Right (100$)</option>
                            <option value="left_space">Left with space ($ 100)</option>
                            <option value="right_space">Right with space (100 $)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Transaction Settings -->
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-cog"></i> Transaction Settings</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Transaction Fee (%)</label>
                        <input type="number" class="form-control" value="2.5" step="0.1" min="0" max="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Minimum Deposit Amount</label>
                        <input type="number" class="form-control" value="10" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Maximum Deposit Amount</label>
                        <input type="number" class="form-control" value="5000" min="100">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="autoApproveDeposits" checked>
                        <label class="form-check-label" for="autoApproveDeposits">Auto-approve Deposits</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection