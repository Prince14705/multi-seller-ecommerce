@extends('admin.dashboard')
@section('title', 'Language Settings')

@section('content')
<div class="container-fluid pt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3"><i class="fas fa-language"></i> Language Settings</h1>
            <p class="text-muted mb-0">Manage website languages and translations</p>
        </div>
        <button class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
    </div>

    <div class="row">
        <!-- Language List -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-globe"></i> Available Languages</h6>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addLanguageModal">
                        <i class="fas fa-plus"></i> Add Language
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Language</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Default</th>
                                    <th>Translation Progress</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="flag-icon flag-icon-us me-2"></span>
                                            <strong>English</strong>
                                        </div>
                                    </td>
                                    <td>en</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="defaultLanguage" checked>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                        </div>
                                        <small>100%</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-info" title="Translate"><i class="fas fa-language"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="flag-icon flag-icon-es me-2"></span>
                                            <strong>Spanish</strong>
                                        </div>
                                    </td>
                                    <td>es</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="defaultLanguage">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: 85%"></div>
                                        </div>
                                        <small>85%</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-info"><i class="fas fa-language"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="flag-icon flag-icon-fr me-2"></span>
                                            <strong>French</strong>
                                        </div>
                                    </td>
                                    <td>fr</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="defaultLanguage">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: 65%"></div>
                                        </div>
                                        <small>65%</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-info"><i class="fas fa-language"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="flag-icon flag-icon-de me-2"></span>
                                            <strong>German</strong>
                                        </div>
                                    </td>
                                    <td>de</td>
                                    <td><span class="badge bg-warning">Inactive</span></td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="defaultLanguage">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-danger" style="width: 30%"></div>
                                        </div>
                                        <small>30%</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-info"><i class="fas fa-language"></i></button>
                                        <button class="btn btn-sm btn-success"><i class="fas fa-toggle-on"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Language Settings -->
        <div class="col-lg-4 mb-4">
            <!-- General Settings -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-cog"></i> General Settings</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Auto-detect Language</label>
                        <select class="form-select">
                            <option value="browser">Based on Browser</option>
                            <option value="ip">Based on IP Location</option>
                            <option value="none" selected>Disabled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Language Switcher Position</label>
                        <select class="form-select">
                            <option value="header" selected>Header</option>
                            <option value="footer">Footer</option>
                            <option value="both">Both Header & Footer</option>
                        </select>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="rtlSupport" checked>
                        <label class="form-check-label" for="rtlSupport">Enable RTL Support</label>
                    </div>
                </div>
            </div>

            <!-- Translation Statistics -->
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-chart-bar"></i> Translation Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Total Phrases</small>
                        <h5>1,245</h5>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Translated Phrases</small>
                        <h5>984</h5>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Untranslated Phrases</small>
                        <h5 class="text-danger">261</h5>
                    </div>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: 79%"></div>
                    </div>
                    <small class="text-muted">Overall Translation Progress: 79%</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Language Modal -->
<div class="modal fade" id="addLanguageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Language</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Language Name</label>
                        <input type="text" class="form-control" placeholder="Enter language name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Language Code</label>
                        <input type="text" class="form-control" placeholder="e.g., en, es, fr">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Direction</label>
                        <select class="form-select">
                            <option value="ltr">Left to Right (LTR)</option>
                            <option value="rtl">Right to Left (RTL)</option>
                        </select>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="newLanguageStatus" checked>
                        <label class="form-check-label" for="newLanguageStatus">Activate Language</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Language</button>
            </div>
        </div>
    </div>
</div>

<style>
.flag-icon {
    width: 20px;
    height: 15px;
    display: inline-block;
    background-size: cover;
    border-radius: 2px;
}
.flag-icon-us { background-image: url('https://via.placeholder.com/20x15/00247D/FFFFFF?text=US'); }
.flag-icon-es { background-image: url('https://via.placeholder.com/20x15/AA151B/FFFFFF?text=ES'); }
.flag-icon-fr { background-image: url('https://via.placeholder.com/20x15/002654/FFFFFF?text=FR'); }
.flag-icon-de { background-image: url('https://via.placeholder.com/20x15/000000/FFFFFF?text=DE'); }
</style>
@endsection