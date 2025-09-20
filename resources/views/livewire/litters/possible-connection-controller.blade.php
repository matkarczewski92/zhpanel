<div>
    {{-- Pasek akcji na górze --}}
    <div class="d-flex align-items-center gap-2 mb-2">
        <div class="input-group" style="max-width: 720px;">
            <span class="input-group-text">Samica:</span>
            <select id="femaleSelect" class="form-select" wire:model.live="selectedFemale">
                <option value="">-- wybierz --</option>
                @foreach($females as $female)
                    @php
                        $isPaired = in_array($female->id, $pairedFemaleIds ?? []);
                        $optStyle = $isPaired ? 'font-weight:600;' : '';
                        $prefix   = $isPaired ? '✓ ' : '';
                    @endphp
                    <option value="{{ $female->id }}" style="{{ $optStyle }}">
                        {!! $prefix !!}{!! $female->name !!}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary"
                type="button"
                wire:click="openSummary">
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
                    $fnMale  = $data['rows'];
                    $checked = $this->isChecked($selectedFemale, $maleId);
                    $used    = $this->maleUsedTimes($maleId);   // ile razy samiec już użyty
                @endphp

                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="mb-2">
                        {!! $name !!}
                        @if($used > 0)
                            <span class="badge text-bg-secondary ms-2">użyty {{ $used }}×</span>
                        @endif
                    </h3>

                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               id="pair-{{ $selectedFemale }}-{{ $maleId }}"
                               wire:change="togglePair({{ $selectedFemale }}, {{ $maleId }})"
                               @checked($checked)>

                        <label class="form-check-label" for="pair-{{ $selectedFemale }}-{{ $maleId }}">
                            dodaj do podsumowania
                            @if($used > 0)
                                <span class="text-muted">(użyty {{ $used }}×)</span>
                            @endif
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
                    @foreach ($fnMale as $row)
                        @php
                            $main_genes = $row['main_genes'];
                            $traits = $row['traits_name'];
                            $additional_genes = $row['additional_genes'];
                            $dominant = $row['dominant'];

                            $hets = array_filter(explode(", ", (string)$additional_genes), fn($v)=>trim($v)!=='');
                            rsort($hets);
                            $newHets = [];
                            foreach ($hets as $h) {
                                if(strpos($h, "50%")!== false){
                                    $newHets[] = '<span class="badge text-bg-secondary">'.$h.'</span>';
                                } elseif(strpos($h, "66%")!== false){
                                    $newHets[] = '<span class="badge text-bg-info">'.$h.'</span>';
                                } elseif(strpos($h, "1/2")!== false){
                                    $newHets[] = '<span class="badge text-bg-danger">'.$h.'</span>';
                                } else {
                                    $newHets[] = '<span class="badge text-bg-primary">'.$h.'</span>';
                                }
                            }

                            $mains = array_filter(explode(", ", (string)$main_genes), fn($v)=>trim($v)!=='');
                            sort($mains);
                            $newMains = [];
                            foreach ($mains as $h) {
                                $newMains[] = '<span class="badge text-bg-success">'.$h.'</span>';
                            }

                            $dom = array_filter(explode(", ", (string)$dominant), fn($v)=>trim($v)!=='');
                            $newDom = [];
                            foreach ($dom as $h) {
                                $newDom[] = '<span class="badge text-bg-danger">'.$h.'</span>';
                            }
                        @endphp
                        <tr>
                            <td>{{ number_format($row['percentage'], 2) }}%</td>
                            <td><span class="badge text-bg-light">{{ $traits }}</span></td>
                            <td>
                                @foreach($newDom as $dom)  {!! $dom !!} @endforeach
                                @foreach($newMains as $mg) {!! $mg  !!} @endforeach
                            </td>
                            <td>@foreach($newHets as $hg) {!! $hg !!} @endforeach</td>
                        </tr>
                    @endforeach
                </table>
                <hr class="mb-5">
            @endforeach
        </div>
    @endif


    {{-- =================== MODAL: PODSUMOWANIE =================== --}}
    @if($showSummary)
        <div class="modal fade show" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Podsumowanie wybranych połączeń</h5>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="closeSummary"></button>
                    </div>

                    <div class="modal-body">
                        @if(!count($selectedPairs))
                            <p class="text-muted mb-0">Nie wybrano żadnych połączeń. Zaznacz checkbox przy nazwie samca.</p>
                        @else
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Razem: {{ count($selectedPairs) }}</span>
                                <button class="btn btn-outline-danger btn-sm" wire:click="clearPairs">Wyczyść wszystko</button>
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
                                        $fId = (int)$pair['female_id']; $mId = (int)$pair['male_id'];
                                        $fName = $femalesMap[$fId] ?? ('ID: '.$fId);
                                        $mName = $malesMap[$mId]   ?? ('ID: '.$mId);
                                        $offspringRows = $this->getPairRows($fId, $mId);
                                    @endphp

                                    {{-- wiersz z parą --}}
                                    <tr>
                                        <td class="align-middle">{!! $fName !!}</td>
                                        <td class="align-middle">{!! $mName !!}</td>
                                        <td class="text-end">
                                            <button class="btn btn-outline-secondary btn-sm"
                                                    wire:click="removePair('{{ $key }}')">
                                                Usuń
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- wiersz z możliwym potomstwem --}}
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
                                                        $main_genes = $row['main_genes'];
                                                        $traits     = $row['traits_name'];
                                                        $additional_genes = $row['additional_genes'];
                                                        $dominant   = $row['dominant'];

                                                        $hets = array_filter(explode(", ", (string)$additional_genes), fn($v)=>trim($v)!=='');
                                                        rsort($hets);
                                                        $newHets = [];
                                                        foreach ($hets as $h) {
                                                            if(strpos($h, "50%")!== false){
                                                                $newHets[] = '<span class="badge text-bg-secondary">'.$h.'</span>';
                                                            } elseif(strpos($h, "66%")!== false){
                                                                $newHets[] = '<span class="badge text-bg-info">'.$h.'</span>';
                                                            } elseif(strpos($h, "1/2")!== false){
                                                                $newHets[] = '<span class="badge text-bg-danger">'.$h.'</span>';
                                                            } else {
                                                                $newHets[] = '<span class="badge text-bg-primary">'.$h.'</span>';
                                                            }
                                                        }

                                                        $mains = array_filter(explode(", ", (string)$main_genes), fn($v)=>trim($v)!=='');
                                                        sort($mains);
                                                        $newMains = [];
                                                        foreach ($mains as $h) {
                                                            $newMains[] = '<span class="badge text-bg-success">'.$h.'</span>';
                                                        }

                                                        $dom = array_filter(explode(", ", (string)$dominant), fn($v)=>trim($v)!=='');
                                                        $newDom = [];
                                                        foreach ($dom as $h) {
                                                            $newDom[] = '<span class="badge text-bg-danger">'.$h.'</span>';
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>{{ number_format($row['percentage'], 2) }}%</td>
                                                        <td><span class="badge text-bg-light">{{ $traits }}</span></td>
                                                        <td>
                                                            @foreach($newDom as $dom)  {!! $dom !!} @endforeach
                                                            @foreach($newMains as $mg) {!! $mg  !!} @endforeach
                                                        </td>
                                                        <td>@foreach($newHets as $hg) {!! $hg !!} @endforeach</td>
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
                        <button class="btn btn-success me-auto" wire:click="openAddLittersModal">
                            Dodaj mioty
                        </button>
                        <button class="btn btn-secondary" wire:click="closeSummary">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show"></div>
    @endif


    {{-- =================== MODAL: DODAJ MIOTY =================== --}}
    @if($showAddLitters)
        <div class="modal fade show" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dodaj mioty</h5>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="closeAddLittersModal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="plannedYear" class="form-label">Podaj planowany rok:</label>
                            <input id="plannedYear"
                                   type="number"
                                   class="form-control"
                                   wire:model.defer="plannedYear"
                                   placeholder="np. 2026">
                        </div>
                        <p class="text-muted small mb-0">
                            Zostaną użyte aktualnie zaznaczone pary z podsumowania.
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" wire:click="closeAddLittersModal">Anuluj</button>
                        <button class="btn btn-primary" wire:click.prevent="addPlanningLitters">Dodaj</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show"></div>
    @endif
</div>
