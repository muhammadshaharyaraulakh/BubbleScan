@use('App\Icons\Ios')
@use('App\Icons\Android')

{{-- Full-screen welcome with animated bubbles background --}}
<native:column class="w-full h-full bg-theme-background safe-area">

    {{-- Animated floating bubbles background --}}
    <native:stack class="w-full flex-1">

        {{-- Background decorative bubbles layer (top hero section only) --}}
        <native:column class="w-full h-full">

            {{-- Top-left bubble cluster --}}
            <native:row class="w-full justify-start px-6 pt-8">
                <native:circle
                    :width="72" :height="72"
                    class="bg-theme-primary/10 rounded-full"
                    :scale="1.15"
                    animate-loop
                    animate-duration="3000"
                    animate-easing="ease-in-out"
                />
            </native:row>

            <native:spacer class="flex-grow-0 h-4" />

            {{-- Top-right floating bubble --}}
            <native:row class="w-full justify-end px-10">
                <native:circle
                    :width="48" :height="48"
                    class="bg-theme-primary/10 rounded-full"
                    :scale="1.2"
                    animate-loop
                    animate-duration="2500"
                    animate-easing="ease-in-out"
                />
            </native:row>
        </native:column>

        {{-- Main content scrollable container --}}
        <native:scroll-view class="w-full h-full px-6 py-4">
            <native:column class="w-full items-center justify-center min-h-full py-6">

                {{-- Hero bubble icon with pulsing ring --}}
                <native:stack class="items-center justify-center mb-6">
                    {{-- Outer pulsing ring --}}
                    <native:circle
                        :width="130" :height="130"
                        class="bg-theme-primary/10 rounded-full"
                        :scale="1.15"
                        animate-loop
                        animate-duration="2000"
                        animate-easing="ease-in-out"
                    />
                    {{-- Inner circle --}}
                    <native:circle
                        :width="104" :height="104"
                        class="bg-theme-primary/20 rounded-full"
                    />
                    {{-- Icon --}}
                    <native:icon
                        :ios="Ios::CameraViewfinder"
                        :android="Android::QrCodeScanner"
                        :size="48"
                        class="text-theme-primary"
                    />
                </native:stack>

                {{-- App name --}}
                <native:text class="text-4xl font-extrabold text-theme-on-background tracking-tight">
                    BubbleScan
                </native:text>

                <native:spacer class="flex-grow-0 h-2" />

                <native:text class="text-base text-theme-on-surface-variant/70 text-center leading-relaxed px-4">
                    The fastest way to grade bubble sheets with your phone's camera.
                </native:text>

                <native:spacer class="flex-grow-0 h-8" />

                {{-- Feature highlights --}}
                <native:column class="w-full gap-3 px-1">
                    <native:row class="w-full items-center gap-4 bg-theme-primary/10 rounded-2xl p-4">
                        <native:icon :ios="Ios::CameraFill" :android="Android::CameraAlt" :size="26" class="text-theme-primary" />
                        <native:column class="flex-1 gap-1">
                            <native:text class="text-base font-bold text-theme-on-surface">Instant Scanning</native:text>
                            <native:text class="text-sm text-theme-on-surface-variant">Point, scan, and get results in seconds</native:text>
                        </native:column>
                    </native:row>

                    <native:row class="w-full items-center gap-4 bg-theme-primary/10 rounded-2xl p-4">
                        <native:icon :ios="Ios::ChartBarFill" :android="Android::BarChart" :size="26" class="text-theme-primary" />
                        <native:column class="flex-1 gap-1">
                            <native:text class="text-base font-bold text-theme-on-surface">Smart Analytics</native:text>
                            <native:text class="text-sm text-theme-on-surface-variant">Detailed reports and performance insights</native:text>
                        </native:column>
                    </native:row>

                    <native:row class="w-full items-center gap-4 bg-theme-primary/10 rounded-2xl p-4">
                        <native:icon :ios="Ios::CheckmarkSealFill" :android="Android::Verified" :size="26" class="text-theme-primary" />
                        <native:column class="flex-1 gap-1">
                            <native:text class="text-base font-bold text-theme-on-surface">Accurate Grading</native:text>
                            <native:text class="text-sm text-theme-on-surface-variant">AI Powered bubble detection for reliability</native:text>
                        </native:column>
                    </native:row>
                </native:column>

                <native:spacer class="flex-grow-0 h-8" />

                {{-- CTA Button with direct client navigation and PHP handler --}}
                <native:button
                    label="Get Started"
                    variant="primary"
                    size="lg"
                    class="w-full"
                    @navigate='/scan'
                    @tap="getStarted"
                />

                <native:spacer class="flex-grow-0 h-4" />

            </native:column>
        </native:scroll-view>
    </native:stack>

</native:column>
