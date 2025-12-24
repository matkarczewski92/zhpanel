<div>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <button type="button"
                    class="nav-link {{ $activeTab === 'builder' ? 'active' : '' }}"
                    wire:click="setActiveTab('builder')">
                Planowanie &#322;&#261;cze&#324;
            </button>
        </li>
        <li class="nav-item">
            <button type="button"
                    class="nav-link {{ $activeTab === 'plans' ? 'active' : '' }}"
                    wire:click="setActiveTab('plans')">
                Opracowane plany
            </button>
        </li>
    </ul>

    @if($activeTab === 'builder')
        {{-- Pasek akcji --}}
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="d-flex justify-content-center my-3 w-100">
                <div class="input-group">
                    <span class="input-group-text">Samica:</span>
                    <select id="femaleSelect" class="form-select" wire:model.live="selectedFemale">
                        <option value="">-- wybierz --</option>
                        @foreach($females as $female)
                            @php
                                $isPaired  = in_array($female->id, $pairedFemaleIds ?? []);
                                $optStyle  = $isPaired ? 'font-weight:600;' : '';
                                $prefix    = $isPaired ? '&#10003; ' : '';
                                $femWeight = $animalRepo->lastWeight($female->id) ?? 0;
                                $femColor  = $femWeight < 250 ? 'text-danger' : ($femWeight < 300 ? 'text-warning' : 'text-success');
                            @endphp
                            <option value="{{ $female->id }}" style="{{ $optStyle }}" class="{{ $femColor }}">
                                {!! $prefix !!} ({{ $femWeight }}g) {!! $female->name !!}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button class="btn btn-primary" type="button" wire:click="openSummary">
                Podsumowanie
                @if(count($selectedPairs))
                    <span class="badge text-bg-light ms-1">{{ count($selectedPairs) }}</span>
                @endif
            </button>
        </div>

        <hr>

        {{-- Wyniki dla wybranej samicy --}}
        @if($selectedFemale)
            <div class="mt-2">
                @foreach ($finale as $maleId => $data)
                    @php
                        $name    = $data['name'];
                        $rows    = $data['rows'];
                        $checked = $this->isChecked($selectedFemale, $maleId);
                        $used    = $this->maleUsedTimes($maleId);
                        $weight  = $animalRepo->lastWeight($maleId) ?? 0;
                        $color   = $weight < 180 ? 'text-danger' : ($weight < 250 ? 'text-warning' : 'text-success');
                    @endphp

                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="mb-2 {{ $color }}">
                            {!! $name !!}
                        </h3>
                        @if($used > 0)
                            <span class="badge text-bg-success ms-2 fs-6 px-2 py-1">
                                u&#380;yty {{ $used }} razy
                            </span>
                        @endif

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="pair-{{ $selectedFemale }}-{{ $maleId }}"
                                   wire:change="togglePair({{ $selectedFemale }}, {{ $maleId }})"
                                   @checked($checked)>

                            <label class="form-check-label" for="pair-{{ $selectedFemale }}-{{ $maleId }}">
                                dodaj do podsumowania
                            </label>
                        </div>
                    </div>

                    <table class="detailsTable">
                        <tr class="border-bottom">
                            <td style="width:8%">Procent</td>
                            <td style="width:10%">Nazwa</td>
                            <td style="width:25%">Homozygota</td>
                            <td style="width:57%">Heterozygota</td>
                        </tr>
                        @foreach ($rows as $row)
                            @php
                                $mainGenes        = $row['main_genes'];
                                $traits          = $row['traits_name'];
                                $additionalGenes = $row['additional_genes'];
                                $dominantGenes   = $row['dominant'];

                                $hets = array_filter(explode(', ', (string) $additionalGenes), fn($v) => trim($v) !== '');
                                rsort($hets);
                                $hetBadges = [];
                                foreach ($hets as $h) {
                                    if (strpos($h, '50%') !== false) {
                                        $hetBadges[] = '<span class="badge text-bg-secondary">'.$h.'</span>';
                                    } elseif (strpos($h, '66%') !== false) {
                                        $hetBadges[] = '<span class="badge text-bg-info">'.$h.'</span>';
                                    } elseif (strpos($h, '1/2') !== false) {
                                        $hetBadges[] = '<span class="badge text-bg-danger">'.$h.'</span>';
                                    } else {
                                        $hetBadges[] = '<span class="badge text-bg-primary">'.$h.'</span>';
                                    }
                                }

                                $mains = array_filter(explode(', ', (string) $mainGenes), fn($v) => trim($v) !== '');
                                sort($mains);
                                $mainBadges = [];
                                foreach ($mains as $m) {
                                    $mainBadges[] = '<span class="badge text-bg-success">'.$m.'</span>';
                                }

                                $dominants = array_filter(explode(', ', (string) $dominantGenes), fn($v) => trim($v) !== '');
                                $domBadges = [];
                                foreach ($dominants as $d) {
                                    $domBadges[] = '<span class="badge text-bg-danger">'.$d.'</span>';
                                }
                            @endphp
                            <tr>
                                <td>{{ number_format($row['percentage'], 2) }}%</td>
                                <td><span class="badge text-bg-light">{{ $traits }}</span></td>
                                <td>
                                    @foreach($domBadges as $dom) {!! $dom !!} @endforeach
                                    @foreach($mainBadges as $main) {!! $main !!} @endforeach
                                </td>
                                <td>@foreach($hetBadges as $het) {!! $het !!} @endforeach</td>
                            </tr>
                        @endforeach
                    </table>
                @endforeach
            </div>
        @endif

        {{-- Modal podsumowania --}}
        @if($showSummary)
            <div class="modal fade show" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Podsumowanie wybranych po&#322;&#261;cze&#324;</h5>
                            <button type="button" class="btn-close" aria-label="Close" wire:click="closeSummary"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="planName" class="form-label">Nazwa planu</label>
                                    <input id="planName"
                                           type="text"
                                           class="form-control @error('planName') is-invalid @enderror"
                                           wire:model.defer="planName"
                                           placeholder="np. Plan zima 2026">
                                    @error('planName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="plannedYear" class="form-label">Planowany rok</label>
                                    <input id="plannedYear"
                                           type="number"
                                           class="form-control @error('plannedYear') is-invalid @enderror"
                                           wire:model.defer="plannedYear"
                                           placeholder="np. 2026">
                                    @error('plannedYear')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-outline-danger w-100" wire:click="clearPairs">Wyczy&#347;&#263; wszystko</button>
                                </div>
                            </div>

                            @if(!count($selectedPairs))
                                <p class="text-muted mb-0">Nie wybrano &#379;adnych po&#322;&#261;cze&#324;. Zaznacz checkbox przy nazwie samca.</p>
                            @else
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Razem: {{ count($selectedPairs) }}</span>
                                </div>

                                <table class="table table-sm align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width:25%">Samica</th>
                                            <th style="width:25%">Samiec</th>
                                            <th style="width:50%" class="text-end">Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($selectedPairs as $key => $pair)
                                            @php
                                                $fId = (int) $pair['female_id'];
                                                $mId = (int) $pair['male_id'];
                                                $offspringRows = $this->getPairRows($fId, $mId);
                                                $femaleName = $femalesMap[$fId] ?? ('ID: '.$fId);
                                                $maleName   = $malesMap[$mId] ?? ('ID: '.$mId);
                                                
                                            @endphp

                                            <tr>
                                                <td class="align-middle">{!! $femaleName !!}</td>
                                                <td class="align-middle">{!! $maleName !!}</td>
                                                <td class="text-end">
                                                    <button class="btn btn-outline-secondary btn-sm"
                                                            wire:click="removePair('{{ $key }}')">
                                                        Usu&#324;
                                                    </button>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="pt-2 pb-4">
                                                    <table class="detailsTable w-100">
                                                        <tr class="border-bottom">
                                                            <td style="width:8%">Procent</td>
                                                            <td style="width:10%">Nazwa</td>
                                                            <td style="width:25%">Homozygota</td>
                                                            <td style="width:57%">Heterozygota</td>
                                                        </tr>
                                                        @foreach ($offspringRows as $row)
                                                            @php
                                                                $mainGenes        = $row['main_genes'];
                                                                $traits          = $row['traits_name'];
                                                                $additionalGenes = $row['additional_genes'];
                                                                $dominantGenes   = $row['dominant'];

                                                                $hets = array_filter(explode(', ', (string) $additionalGenes), fn($v) => trim($v) !== '');
                                                                rsort($hets);
                                                                $hetBadges = [];
                                                                foreach ($hets as $h) {
                                                                    if (strpos($h, '50%') !== false) {
                                                                        $hetBadges[] = '<span class="badge text-bg-secondary">'.$h.'</span>';
                                                                    } elseif (strpos($h, '66%') !== false) {
                                                                        $hetBadges[] = '<span class="badge text-bg-info">'.$h.'</span>';
                                                                    } elseif (strpos($h, '1/2') !== false) {
                                                                        $hetBadges[] = '<span class="badge text-bg-danger">'.$h.'</span>';
                                                                    } else {
                                                                        $hetBadges[] = '<span class="badge text-bg-primary">'.$h.'</span>';
                                                                    }
                                                                }

                                                                $mains = array_filter(explode(', ', (string) $mainGenes), fn($v) => trim($v) !== '');
                                                                sort($mains);
                                                                $mainBadges = [];
                                                                foreach ($mains as $m) {
                                                                    $mainBadges[] = '<span class="badge text-bg-success">'.$m.'</span>';
                                                                }

                                                                $dominants = array_filter(explode(', ', (string) $dominantGenes), fn($v) => trim($v) !== '');
                                                                $domBadges = [];
                                                                foreach ($dominants as $d) {
                                                                    $domBadges[] = '<span class="badge text-bg-danger">'.$d.'</span>';
                                                                }
                                                            @endphp
                                                            <tr>
                                                                <td>{{ number_format($row['percentage'], 2) }}%</td>
                                                                <td><span class="badge text-bg-light">{{ $traits }}</span></td>
                                                                <td>
                                                                    @foreach($domBadges as $dom) {!! $dom !!} @endforeach
                                                                    @foreach($mainBadges as $main) {!! $main !!} @endforeach
                                                                </td>
                                                                <td>@foreach($hetBadges as $het) {!! $het !!} @endforeach</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" wire:click.prevent="savePlan" @if(empty($selectedPairs)) disabled @endif>
                                Zapisz plan
                            </button>
                            <button class="btn btn-outline-secondary" wire:click="closeSummary">Zamknij</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-backdrop fade show"></div>
        @endif
    @else
        @if($saveMessage)
            <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                <span>{{ $saveMessage }}</span>
                <button type="button" class="btn btn-sm btn-link text-reset" wire:click="$set('saveMessage', null)">&times;</button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Zapisane plany</h5>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" wire:click="setActiveTab('builder')">Powr&#243;t do planowania</button>
                <button class="btn btn-primary" wire:click="newPlan">Nowy plan</button>
            </div>
        </div>

        @if($plans->isEmpty())
            <div class="alert alert-secondary">
                Brak zapisanych plan&#243;w. Przejd&#378; do zak&#322;adki &bdquo;Planowanie &#322;&#261;cze&#324;&rdquo;, wybierz pary i zapisz pierwszy plan.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-dark table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nazwa planu</th>
                            <th class="text-center">Rok</th>
                            <th class="text-center">Liczba par</th>
                            <th>Ostatnia aktualizacja</th>
                            <th>Parowanie</th>
                            <th style="width:220px" class="text-end">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plans as $plan)
                            <tr>
                                <td>{{ $plan->name }}</td>
                                <td class="text-center">{{ $plan->planned_year ?? '&mdash;' }}</td>
                                <td class="text-center">{{ $plan->pairs->count() }}</td>
                                <td>{{ optional($plan->updated_at)->format('Y-m-d H:i') ?? '&mdash;' }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($plan->pairs as $pair)
                                            @php
                                                $femaleName = optional($pair->female)->name ?? ($femalesMap[$pair->female_id] ?? 'Samica #'.$pair->female_id);
                                                $maleName   = optional($pair->male)->name ?? ($malesMap[$pair->male_id] ?? 'Samiec #'.$pair->male_id);
                                            @endphp
                                            <span class="badge text-bg-secondary">{!! $femaleName !!} &times; {!! $maleName !!}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-end">
                                    @php $confirm = addslashes($plan->name); @endphp
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary" wire:click="loadPlan({{ $plan->id }})">
                                            Edytuj
                                        </button>
                                        <button class="btn btn-outline-success" wire:click="requestRealizePlan({{ $plan->id }})">
                                            Realizuj
                                        </button>
                                        <button class="btn btn-outline-danger"
                                                wire:click="deletePlan({{ $plan->id }})"
                                                onclick="confirm('Usun&#261;&#263; plan {{ $confirm }}?') || event.stopImmediatePropagation()">
                                            Usu&#324;
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    {{-- Modal realizacji planu --}}
    @if($showPlanRealizeModal)
        <div class="modal fade show" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Realizuj plan</h5>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="cancelRealizePlan"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="realizePlannedYear" class="form-label">Planowany rok</label>
                            <input id="realizePlannedYear"
                                   type="number"
                                   class="form-control @error('plannedYear') is-invalid @enderror"
                                   wire:model.defer="plannedYear"
                                   placeholder="np. 2026">
                            @error('plannedYear')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <p class="text-muted small mb-0">
                            Po zatwierdzeniu plan zostanie zrealizowany jako mioty planowane.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" wire:click="cancelRealizePlan">Anuluj</button>
                        <button class="btn btn-primary" wire:click.prevent="realizePlan">Realizuj</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show"></div>
    @endif
</div>






