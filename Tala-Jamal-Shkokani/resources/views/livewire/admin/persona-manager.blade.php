<div class="animate-fade-in">
    <div class="mb-5">
        <h1 class="h2 mb-1" style="font-family: var(--font-heading); font-weight: 700;">Persona Rewards</h1>
        <p class="text-muted small mb-0">Manage global discounts based on user aesthetic personas.</p>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form wire:submit.prevent="save">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr class="text-muted extra-small text-uppercase fw-bold ls-1 border-0">
                                        <th class="border-0 ps-0">Aesthetic Persona</th>
                                        <th class="border-0">Global Discount (%)</th>
                                        <th class="border-0 text-end">Applicability</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($aesthetics as $key => $name)
                                        <tr class="border-top">
                                            <td class="ps-0 py-4">
                                                <div class="fw-bold text-dark">{{ $name }}</div>
                                                <div class="extra-small text-muted text-uppercase ls-1">{{ $key }} persona
                                                </div>
                                            </td>
                                            <td style="width: 200px;">
                                                <div class="input-group">
                                                    <input type="number" step="0.1" wire:model="discounts.{{ $key }}"
                                                        class="form-control border-0 bg-light rounded-start-3"
                                                        placeholder="0">
                                                    <span class="input-group-text border-0 bg-light rounded-end-3">%</span>
                                                </div>
                                            </td>
                                            <td class="text-end text-muted small">
                                                Applies to all <strong>{{ $key }}</strong> pieces
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-luxury px-5">
                                <i class="fa fa-save me-2"></i> Save Adjustments
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 p-4 bg-light rounded-4 border">
                <h6 class="fw-bold mb-3"><i class="fa fa-info-circle me-2 text-primary"></i> Discount Engine Logic</h6>
                <p class="small text-muted mb-0">
                    The system calculates the final piece investment by applying the <strong>highest available
                        discount</strong> from three tiers:
                </p>
                <ul class="small text-muted mt-2">
                    <li>Individual Piece Discount</li>
                    <li>Collection (Category) Global Discount</li>
                    <li>Persona (Aesthetic) Global Discount</li>
                </ul>
                <p class="extra-small text-uppercase fw-bold ls-1 mt-3 mb-0">example</p>
                <p class="small text-muted">
                    If a "Luxury Clean" piece has a 5% discount, but its "Jewelry" collection has a 10% discount, and
                    the "Luxury" persona has a 15% discount, the client pays 15% less.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4">
                <h5 class="fw-bold mb-3" style="font-family: var(--font-heading);">Elite Insights</h5>
                <p class="small opacity-75">Adjusting persona discounts is a powerful tool to drive engagement for
                    specific style tribes.</p>
                <hr class="opacity-25">
                <div class="d-flex justify-content-between mb-2">
                    <span class="small">Soft Femme Base</span>
                    <span class="fw-bold text-primary">{{ $discounts['soft'] }}%</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small">Alt Girly Base</span>
                    <span class="fw-bold text-primary">{{ $discounts['alt'] }}%</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small">Luxury Clean Base</span>
                    <span class="fw-bold text-primary">{{ $discounts['luxury'] }}%</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="small">Modern Mix Base</span>
                    <span class="fw-bold text-primary">{{ $discounts['mix'] }}%</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .extra-small {
            font-size: 0.65rem;
        }

        .ls-1 {
            letter-spacing: 1.5px;
        }

        .bg-danger-subtle {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545 !important;
        }

        .text-primary {
            color: #F6A6B2 !important;
        }
    </style>
</div>