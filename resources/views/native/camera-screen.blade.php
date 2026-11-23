@use('App\Icons\Ios')
@use('App\Icons\Android')

<native:column class="w-full h-full bg-theme-background safe-area">
    {{-- Back button top left to go back to /scan --}}
    <native:row class="w-full items-center px-4 pt-2 pb-1">
        <native:pressable @navigate.back @tap="goBack" class="p-2 -ml-2 rounded-lg">
            <native:row class="items-center gap-1">
                <native:icon :ios="Ios::ChevronLeft" :android="Android::ArrowBack" :size="22" class="text-theme-primary" />
                <native:text class="text-sm font-semibold text-theme-primary">Setup</native:text>
            </native:row>
        </native:pressable>
    </native:row>

    <native:column class="w-full flex-1 px-5 py-2 justify-between">
        {{-- Heading and Subtext --}}
        <native:column class="w-full gap-1 mb-2">
            <native:text class="text-3xl font-extrabold text-theme-on-background tracking-tight">
                Scan Bubble Sheet
            </native:text>
            <native:text class="text-sm text-theme-on-surface-variant">
                Point camera at the filled bubble sheet
            </native:text>
        </native:column>

        {{-- Center Area / Image Preview --}}
        <native:column class="w-full flex-1 my-3 items-center justify-center">
            @if (! $imageCaptured)
                <native:spacer />
            @else
                {{-- After Capture: Captured Image Preview --}}
                <native:column class="w-full flex-1 max-h-[460px] bg-theme-surface rounded-3xl p-3 items-center justify-between border-2 border-theme-primary shadow-lg gap-2">
                    <native:row class="items-center bg-green-50 rounded-full px-3 py-1 gap-1 border border-green-200">
                        <native:icon :ios="Ios::CheckmarkCircleFill" :android="Android::CheckCircle" :size="14" class="text-green-600" />
                        <native:text class="text-xs font-bold text-green-700">Sheet Captured Successfully</native:text>
                    </native:row>

                    {{-- Captured image display --}}
                    <native:column class="w-full flex-1 rounded-2xl bg-slate-100 items-center justify-center">
                        <native:image
                            src="{{ $capturedImage }}"
                            class="w-full flex-1 rounded-2xl"
                            fit="contain"
                            alt="Captured Bubble Sheet Preview"
                        />
                    </native:column>

                    <native:text class="text-xs text-theme-on-surface-variant font-medium">
                        Preview looks clear. Ready for optical bubble analysis.
                    </native:text>
                </native:column>
            @endif
        </native:column>

        {{-- Bottom Action Buttons --}}
        <native:column class="w-full gap-3 pb-4">
            @if (! $imageCaptured)
                {{-- Orange Capture button at bottom --}}
                <native:button
                    label="Capture"
                    variant="primary"
                    size="lg"
                    class="w-full"
                    @tap="capture"
                />
            @else
                {{-- Orange Process & Get Results button --}}
                <native:button
                    label="Process & Get Results"
                    variant="primary"
                    size="lg"
                    class="w-full"
                    @navigate='/result'
                    @tap="processImage"
                />
                {{-- Retake button to capture again --}}
                <native:button
                    label="Retake"
                    variant="secondary"
                    size="md"
                    class="w-full"
                    @tap="retake"
                />
            @endif
        </native:column>
    </native:column>
</native:column>
