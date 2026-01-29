@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-5">
        <h2 class="fw-black text-dark mb-1">System Settings</h2>
        <p class="text-secondary small">Configure your application preferences</p>
    </div>

    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <div class="list-group list-group-flush settings-nav">
                    <a href="#general" class="list-group-item list-group-item-action active p-3 border-0" data-bs-toggle="list">
                        <i class="bi bi-pc-display-horizontal me-3"></i>General Settings
                    </a>
                    <a href="#booking" class="list-group-item list-group-item-action p-3 border-0" data-bs-toggle="list">
                        <i class="bi bi-calendar-event me-3"></i>Booking Logic
                    </a>
                    <a href="#payment" class="list-group-item list-group-item-action p-3 border-0" data-bs-toggle="list">
                        <i class="bi bi-wallet2 me-3"></i>Payment Gateways
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">
            <div class="tab-content border-0">

                <!-- Tab: General Settings -->
                <div class="tab-pane fade show active" id="general">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4 text-dark border-bottom pb-3"><i class="bi bi-gear-fill me-2 text-primary"></i> General Preferences</h5>
                        <form class="text-dark">
                            <div class="row g-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase opacity-75">Site Title</label>
                                    <input type="text" class="form-control form-control-lg bg-light" value="BusCam">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase opacity-75">Local Timezone</label>
                                    <select class="form-select form-control-lg bg-light">
                                        <option selected>Africa/Douala</option>
                                        <option>Africa/Yaounde</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold small text-uppercase opacity-75">Platform Description</label>
                                    <textarea class="form-control bg-light" rows="3">Secure online bus ticket booking platform for Cameroon.</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase opacity-75">Support Email Address</label>
                                    <input type="email" class="form-control bg-light" value="support@buscam.cm">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase opacity-75">Public Phone Line</label>
                                    <input type="tel" class="form-control bg-light" value="+237 XXX XXX XXX">
                                </div>
                            </div>
                            <div class="text-end mt-4 pt-4 border-top">
                                <button type="submit" class="btn btn-primary px-5 fw-bold rounded-pill">Update Platform</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tab: Booking Settings -->
                <div class="tab-pane fade" id="booking">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4 text-dark border-bottom pb-3"><i class="bi bi-calendar2-check-fill me-2 text-success"></i> Booking Logic</h5>
                        <form class="text-dark">
                            <div class="row g-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase opacity-75">Standard Service Fee (FCFA)</label>
                                    <input type="number" class="form-control bg-light" value="500">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small text-uppercase opacity-75">Limit Seats per Booking</label>
                                    <input type="number" class="form-control bg-light" value="5">
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="form-check form-switch bg-light p-3 rounded-3 border">
                                        <input class="form-check-input ms-0" type="checkbox" id="autoConfirmed" checked>
                                        <label class="form-check-label ms-3 fw-bold" for="autoConfirmed">
                                            Immediately confirm ticket after successful payment
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-2 pt-4 border-top">
                                <button type="submit" class="btn btn-primary px-5 fw-bold rounded-pill">Save Logic</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tab: Payment Settings -->
                <div class="tab-pane fade" id="payment">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4 text-dark border-bottom pb-3"><i class="bi bi-credit-card-2-front-fill me-2 text-info"></i> Financial Gateways</h5>
                        <form class="text-dark">
                            <div class="mb-4">
                                <div class="form-check form-switch bg-primary-subtle p-3 rounded-3 mb-3 border border-primary">
                                    <input class="form-check-input ms-0" type="checkbox" id="momoToggle" checked>
                                    <label class="form-check-label ms-3 fw-black text-primary" for="momoToggle">Active: Mobile Money Payments</label>
                                </div>
                                <div class="row g-3 px-2">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">MTN API Key</label>
                                        <input type="password" class="form-control bg-light" placeholder="••••••••••••••">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Orange API Key</label>
                                        <input type="password" class="form-control bg-light" placeholder="••••••••••••••">
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4 pt-4 border-top">
                                <button type="submit" class="btn btn-primary px-5 fw-bold rounded-pill">Secure Settings</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900 !important; }
    .settings-nav a.active { background-color: #0d6efd !important; color: white !important; font-weight: bold; }
    .form-control:focus { box-shadow: none; border-color: #0d6efd; }
</style>
@endsection
