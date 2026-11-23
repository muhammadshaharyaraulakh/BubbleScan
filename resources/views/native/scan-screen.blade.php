@use('App\Icons\Ios')
@use('App\Icons\Android')

<native:column class="w-full h-full bg-theme-background safe-area">
    {{-- Back navigation button --}}
    <native:row class="w-full items-center px-4 pt-2 pb-1">
        <native:pressable @navigate.back @tap="goBack" class="p-2 -ml-2 rounded-lg">
            <native:row class="items-center gap-1">
                <native:icon :ios="Ios::ChevronLeft" :android="Android::ArrowBack" :size="22" class="text-theme-primary" />
                <native:text class="text-sm font-semibold text-theme-primary">Home</native:text>
            </native:row>
        </native:pressable>
    </native:row>

    <native:scroll-view class="w-full flex-1 px-5 py-2">
        {{-- Screen Heading --}}
        <native:column class="w-full gap-1 mb-5">
            <native:text class="text-3xl font-extrabold text-theme-on-background tracking-tight">
                Setup Answer Key
            </native:text>
            <native:text class="text-sm text-theme-on-surface-variant">
                Configure question count and answer key before scanning sheets.
            </native:text>
        </native:column>

        @if (! $keySaved)
            {{-- Setup Form Card --}}
            <native:column class="w-full bg-theme-surface rounded-2xl p-5 border border-theme-outline-variant shadow-sm gap-4 mb-6">
                {{-- Field 1: Total MCQs --}}
                <native:column class="w-full gap-1.5">
                    <native:text class="text-xs font-bold text-theme-on-surface-variant uppercase tracking-wider">
                        Number of MCQs
                    </native:text>
                    <native:outlined-text-input
                        native:model.debounce.300ms="totalMcqs"
                        label="Number of MCQs"
                        placeholder="Number of MCQs"
                        keyboard="number"
                        class="w-full"
                    />
                </native:column>

                {{-- Field 2: Answers Input --}}
                <native:column class="w-full gap-1.5">
                    <native:text class="text-xs font-bold text-theme-on-surface-variant uppercase tracking-wider">
                        Answers Sequence
                    </native:text>
                    <native:outlined-text-input
                        native:model.debounce.300ms="input"
                        label="Paste answers comma separated e.g. A,B,C,D,A (sequence wise)"
                        placeholder="Paste answers comma separated e.g. A,B,C,D,A (sequence wise)"
                        multiline
                        :min-lines="3"
                        :max-lines="6"
                        autocapitalize="characters"
                        class="w-full"
                    />
                    <native:text class="text-xs text-theme-on-surface-variant/80">
                        Only options A, B, C, D are permitted. Separate answers by commas.
                    </native:text>
                </native:column>

                {{-- Validation Error Banner --}}
                @if ($errorMessage)
                    <native:row class="w-full items-center gap-2 bg-red-50 p-3.5 rounded-xl border border-red-200">
                        <native:icon :ios="Ios::XmarkCircleFill" :android="Android::Cancel" :size="20" class="text-red-500" />
                        <native:text class="text-xs font-semibold text-red-600 flex-1">
                            {{ $errorMessage }}
                        </native:text>
                    </native:row>
                @endif

                <native:spacer class="flex-grow-0 h-1" />

                {{-- Orange Save Button --}}
                <native:button
                    label="Save"
                    variant="primary"
                    size="lg"
                    class="w-full"
                    @tap="saveKey"
                />
            </native:column>
        @else
            {{-- Answer Key Card --}}
            <native:column class="w-full bg-theme-surface rounded-2xl p-5 border border-theme-outline-variant shadow-sm gap-4 mb-4">
                <native:row class="w-full items-center justify-between">
                    <native:column class="gap-0.5 flex-1">
                        <native:text class="text-lg font-bold text-theme-on-surface">
                            Answer Key ({{ $totalMcqs }} Questions)
                        </native:text>
                        <native:row class="items-center gap-1">
                            <native:icon :ios="Ios::CheckmarkCircleFill" :android="Android::CheckCircle" :size="14" class="text-theme-success" />
                            <native:text class="text-xs font-semibold text-theme-success">
                                Saved and verified
                            </native:text>
                        </native:row>
                    </native:column>

                    {{-- Delete icon to clear and re-enter --}}
                    <native:pressable @tap="deleteKey" class="p-2.5 rounded-xl bg-red-50">
                        <native:icon :ios="Ios::TrashFill" :android="Android::Delete" :size="20" class="text-theme-destructive" />
                    </native:pressable>
                </native:row>

                <native:divider class="w-full" />

                {{-- Comma-separated Answer String --}}
                <native:column class="w-full gap-1 bg-theme-surface-variant p-3.5 rounded-xl">
                    <native:text class="text-xs font-bold text-theme-on-surface-variant uppercase tracking-wider">
                        Sequence
                    </native:text>
                    <native:text class="text-base font-bold text-theme-primary tracking-widest">
                        {{ $answerKey }}
                    </native:text>
                </native:column>

                {{-- Question badges breakdown --}}
                <native:column class="w-full gap-2">
                    <native:text class="text-xs font-bold text-theme-on-surface-variant uppercase tracking-wider">
                        Question Mapping
                    </native:text>
                    <native:row class="w-full flex-wrap gap-2">
                        @foreach (explode(',', $answerKey) as $idx => $ans)
                            <native:row class="items-center bg-theme-primary/10 rounded-lg px-2.5 py-1.5 gap-1.5 border border-theme-primary/20">
                                <native:text class="text-xs font-bold text-theme-on-surface-variant">Q{{ $idx + 1 }}:</native:text>
                                <native:text class="text-sm font-extrabold text-theme-primary">{{ $ans }}</native:text>
                            </native:row>
                        @endforeach
                    </native:row>
                </native:column>
            </native:column>

            {{-- Orange Scan Now Button appears below card --}}
            <native:column class="w-full gap-3 pt-2 pb-6">
                <native:button
                    label="Scan Now"
                    variant="primary"
                    size="lg"
                    class="w-full"
                    @navigate='/camera'
                    @tap="scanNow"
                />
            </native:column>
        @endif
    </native:scroll-view>
</native:column>
