@use('App\Icons\Ios')
@use('App\Icons\Android')

<native:column class="w-full h-full bg-theme-background safe-area">
    <native:scroll-view class="w-full flex-1 px-5 py-3">
        {{-- Screen Title --}}
        <native:column class="w-full gap-0.5 mb-3 items-center">
            <native:text class="text-2xl font-extrabold text-theme-on-background tracking-tight">
                Grading Results
            </native:text>
            <native:text class="text-xs text-theme-on-surface-variant font-medium">
                BubbleScan Automated Evaluation
            </native:text>
        </native:column>

        {{-- Big orange score circle in center --}}
        <native:stack class="w-full items-center justify-center my-3">
            <native:circle
                :width="156"
                :height="156"
                class="bg-theme-primary/15 rounded-full"
            />
            <native:circle
                :width="128"
                :height="128"
                class="bg-theme-primary rounded-full"
            />
            <native:column class="items-center justify-center">
                <native:text class="text-4xl font-extrabold text-white tracking-tight">
                    {{ (int) $scorePercentage }}%
                </native:text>
                <native:text class="text-[11px] font-bold text-white/90 tracking-widest mt-0.5">
                    SCORE
                </native:text>
            </native:column>
        </native:stack>

        <native:spacer class="flex-grow-0 h-2" />

        {{-- Detailed Report Table --}}
        <native:column class="w-full gap-2 mb-6">
            <native:row class="w-full items-center justify-between mb-1">
                <native:text class="text-base font-bold text-theme-on-background">
                    Detailed Report Table
                </native:text>
                <native:text class="text-xs font-semibold text-theme-on-surface-variant">
                    Total: {{ $totalMcqs }} Questions
                </native:text>
            </native:row>

            {{-- Rows: Q1 | Student Ans: A | Correct: A | Status --}}
            <native:column class="w-full gap-2">
                @foreach ($reportRows as $row)
                    <native:row class="w-full items-center justify-between px-3.5 py-3 rounded-xl border {{ $row['is_correct'] ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                        {{-- Question number --}}
                        <native:text class="text-sm font-extrabold {{ $row['is_correct'] ? 'text-green-900' : 'text-red-900' }} w-8">
                            Q{{ $row['question'] }}
                        </native:text>

                        {{-- Student Answer --}}
                        <native:text class="text-xs font-semibold {{ $row['is_correct'] ? 'text-green-800' : 'text-red-800' }}">
                            Student Ans: {{ $row['student_answer'] }}
                        </native:text>

                        {{-- Correct Answer --}}
                        <native:text class="text-xs font-semibold {{ $row['is_correct'] ? 'text-green-800' : 'text-red-800' }}">
                            Correct: {{ $row['correct_answer'] }}
                        </native:text>

                        {{-- Status Icon (Checkmark or Cross) --}}
                        <native:icon
                            :ios="$row['is_correct'] ? Ios::CheckmarkCircleFill : Ios::XmarkCircleFill"
                            :android="$row['is_correct'] ? Android::CheckCircle : Android::Cancel"
                            :size="20"
                            class="{{ $row['is_correct'] ? 'text-green-600' : 'text-red-500' }}"
                        />
                    </native:row>
                @endforeach
            </native:column>
        </native:column>

        {{-- Bottom buttons --}}
        <native:column class="w-full gap-3 pt-1 pb-6">
            {{-- Orange Scan Another button --}}
            <native:button
                label="Scan Another"
                variant="primary"
                size="lg"
                class="w-full"
                @navigate='/scan'
                @tap="scanAnother"
            />

            {{-- Gray Home button --}}
            <native:button
                label="Home"
                variant="secondary"
                size="md"
                class="w-full"
                @navigate='/'
                @tap="goHome"
            />
        </native:column>
    </native:scroll-view>
</native:column>
