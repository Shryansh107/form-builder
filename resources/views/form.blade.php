@extends('layouts.admin')

@section('content')
<!-- Google Fonts & Tailwind CDN -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    :root {
        --colors-primary: #111111;
        --colors-primary-active: #242424;
        --colors-primary-disabled: #e5e7eb;
        --colors-ink: #111111;
        --colors-body: #374151;
        --colors-muted: #6b7280;
        --colors-muted-soft: #898989;
        --colors-hairline: #e5e7eb;
        --colors-hairline-soft: #f3f4f6;
        --colors-canvas: #ffffff;
        --colors-surface-soft: #f8f9fa;
        --colors-surface-card: #f5f5f5;
        --colors-surface-strong: #e5e7eb;
    }

    body {
        background-color: var(--colors-canvas) !important;
        color: var(--colors-body) !important;
    }

    /* Scoped styling to prevent Tailwind preflight from breaking Bootstrap layout */
    .form-builder-app {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }
    
    /* Fix bootstrap navigation lists that Tailwind resets */
    .doc-sidebar ul, .app-header1 ul {
        list-style: none !important;
        margin: 0 !important;
        padding-left: 0 !important;
    }
    .doc-sidebar a, .app-header1 a {
        text-decoration: none !important;
    }
    /* Hide the empty LMS sidebar to reclaim full width */
    .app-sidebar.doc-sidebar {
        display: none !important;
    }
    .app-content {
        margin-left: 0 !important;
    }

    /* Custom scrollbars for a premium feel */
    .premium-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .premium-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .premium-scrollbar::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 9999px;
    }
    .premium-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    /* Ghost/Drag styling */
    .ghost-class {
        border: 2px dashed var(--colors-ink) !important;
        background-color: var(--colors-surface-soft) !important;
        opacity: 0.6;
        border-radius: 12px !important;
    }

    /* Fixed sidebar on the right */
    .fb-sidebar-fixed {
        position: fixed;
        top: 64px; /* below sticky 64px navbar */
        right: 0;
        width: 360px;
        height: calc(100vh - 64px);
        overflow-y: auto;
        z-index: 30;
        background: var(--colors-canvas);
        border-left: 1px solid var(--colors-hairline);
        transition: transform 0.2s ease, width 0.2s ease;
    }

    /* Canvas area takes remaining width and scrolls independently */
    .fb-canvas-scroll {
        margin-right: 360px; /* sidebar width */
        height: calc(100vh - 64px);
        overflow-y: auto;
        background-color: var(--colors-canvas);
        transition: margin-right 0.2s ease;
    }

    /* Navbar controls styling absolutely positioned over the navbar */
    .navbar-fb-controls {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: fixed;
        top: 0;
        right: 24px;
        height: 64px;
        z-index: 1000;
    }

    /* Collapsed state classes */
    .sidebar-collapsed .fb-sidebar-fixed {
        transform: translateX(100%);
        width: 0 !important;
        pointer-events: none;
    }
    .sidebar-collapsed .fb-canvas-scroll {
        margin-right: 0 !important;
    }

    /* Cal.com Input Style Overrides */
    .form-builder-app input[type="text"],
    .form-builder-app input[type="email"],
    .form-builder-app input[type="number"],
    .form-builder-app input[type="tel"],
    .form-builder-app input[type="url"],
    .form-builder-app input[type="date"],
    .form-builder-app select,
    .form-builder-app textarea {
        font-family: 'Inter', sans-serif !important;
        background-color: var(--colors-canvas) !important;
        color: var(--colors-ink) !important;
        border: 1px solid var(--colors-hairline) !important;
        border-radius: 8px !important;
        height: 40px;
        padding: 10px 14px !important;
        font-size: 14px !important;
        transition: all 0.15s ease-in-out !important;
        box-shadow: none !important;
    }
    .form-builder-app textarea {
        height: auto !important;
        min-height: 100px !important;
    }
    .form-builder-app input:focus,
    .form-builder-app select:focus,
    .form-builder-app textarea:focus {
        border-color: var(--colors-ink) !important;
        outline: none !important;
        box-shadow: 0 0 0 2px rgba(17, 17, 17, 0.1) !important;
    }
    .form-builder-app input[disabled],
    .form-builder-app select[disabled],
    .form-builder-app textarea[disabled] {
        background-color: var(--colors-surface-soft) !important;
        border-color: var(--colors-hairline) !important;
        color: var(--colors-muted) !important;
        cursor: not-allowed !important;
    }

    /* Buttons */
    .btn-cal-primary {
        background-color: var(--colors-ink) !important;
        color: #ffffff !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        border: none !important;
        border-radius: 6px !important;
        height: 36px !important;
        padding: 0 16px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        cursor: pointer !important;
        transition: background 0.15s !important;
    }
    .btn-cal-primary:hover:not(:disabled) {
        background-color: var(--colors-primary-active) !important;
    }
    .btn-cal-primary:disabled {
        background-color: var(--colors-primary-disabled) !important;
        color: var(--colors-muted) !important;
        cursor: not-allowed !important;
    }

    .btn-cal-secondary {
        background-color: #ffffff !important;
        color: var(--colors-ink) !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        border: 1px solid var(--colors-hairline) !important;
        border-radius: 6px !important;
        height: 36px !important;
        padding: 0 16px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        cursor: pointer !important;
        transition: background 0.15s !important;
    }
    .btn-cal-secondary:hover:not(:disabled) {
        background-color: var(--colors-surface-soft) !important;
    }
    .btn-cal-secondary:disabled {
        color: var(--colors-muted) !important;
        cursor: not-allowed !important;
        opacity: 0.5 !important;
    }

    .btn-cal-icon {
        background-color: #ffffff !important;
        color: var(--colors-ink) !important;
        border: 1px solid var(--colors-hairline) !important;
        border-radius: 6px !important;
        height: 36px !important;
        width: 36px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        transition: all 0.15s !important;
    }
    .btn-cal-icon:hover:not(:disabled) {
        background-color: var(--colors-surface-soft) !important;
    }
    .btn-cal-icon:disabled {
        opacity: 0.3 !important;
        cursor: not-allowed !important;
    }

    .nav-pill-group-cal {
        background-color: var(--colors-surface-soft);
        padding: 4px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        border: 1px solid var(--colors-hairline);
    }
    .nav-pill-group-cal button {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
        font-family: 'Inter', sans-serif;
    }

    .canvas-header-input {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important;
        height: auto !important;
    }
    .canvas-header-input:focus {
        box-shadow: none !important;
        border-color: transparent !important;
        outline: none !important;
        background: transparent !important;
    }

    /* Side-by-side card labels and inputs */
    .placed-field-wrapper .pointer-events-none > div > div {
        display: flex !important;
        align-items: center !important;
        gap: 1.25rem !important;
        flex-wrap: nowrap !important;
    }
    .placed-field-wrapper .pointer-events-none > div > div > label {
        width: 130px !important;
        flex-shrink: 0 !important;
        margin-bottom: 0 !important;
        font-size: 13px !important;
        color: #374151 !important;
    }
    .placed-field-wrapper .pointer-events-none > div > div > :not(label) {
        flex-grow: 1 !important;
        width: 100% !important;
    }
    /* Disable flex on structural layout blocks */
    .placed-field-wrapper .pointer-events-none > [x-show*="layout"] > div {
        display: block !important;
    }
    .placed-field-wrapper .pointer-events-none > [x-show*="layout"] h2,
    .placed-field-wrapper .pointer-events-none > [x-show*="layout"] p {
        width: auto !important;
        margin: 0 !important;
    }

    /* Hide subtext metadata below inputs in builder cards */
    .placed-field-wrapper .mt-1.flex {
        display: none !important;
    }

    @media (max-width: 1023px) {
        .fb-sidebar-fixed {
            position: static;
            width: 100% !important;
            height: auto;
            border-left: none;
            border-top: 1px solid var(--colors-hairline);
        }
        .fb-canvas-scroll {
            margin-right: 0 !important;
            height: auto;
            overflow-y: visible;
        }
        .sidebar-collapsed .fb-sidebar-fixed {
            transform: none;
            width: 100% !important;
            display: none !important;
        }
    }
</style>

<div class="app-content form-builder-app bg-white" :class="sidebarOpen ? '' : 'sidebar-collapsed'" x-data="formBuilder()" x-init="init()" style="padding-top: 0; margin-left: 0 !important;">

    {{-- Toolbar controls visually positioned inside the top navbar --}}
    <div class="navbar-fb-controls">
        <!-- View mode toggle (Nav pill group style) -->
        <div class="nav-pill-group-cal">
            <button 
                @click="toggleViewMode('builder')" 
                :style="activeViewMode === 'builder' ? 'background:#ffffff; color:var(--colors-ink); box-shadow: 0 1px 2px rgba(0,0,0,.08);' : 'background:transparent; color:var(--colors-muted);'"
            >
                Builder
            </button>
            <button 
                @click="toggleViewMode('preview')" 
                :style="activeViewMode === 'preview' ? 'background:#ffffff; color:var(--colors-ink); box-shadow: 0 1px 2px rgba(0,0,0,.08);' : 'background:transparent; color:var(--colors-muted);'"
            >
                Preview
            </button>
        </div>

        <!-- Undo/Redo -->
        <div class="flex items-center gap-1">
            <button 
                @click="undo()" 
                :disabled="undoStack.length === 0"
                class="btn-cal-icon"
                title="Undo (Ctrl+Z)"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button 
                @click="redo()" 
                :disabled="redoStack.length === 0"
                class="btn-cal-icon"
                title="Redo (Ctrl+Y)"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Clear -->
        <button 
            @click="clearCanvas()" 
            class="btn-cal-secondary"
            style="color: #ef4444 !important; border-color: rgba(239, 68, 68, 0.2) !important;"
            onmouseover="this.style.background='#fef2f2'"
            onmouseout="this.style.background='#ffffff'"
        >
            <svg style="height:14px; width:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <span>Clear</span>
        </button>

        <!-- Build Form -->
        <button 
            @click="showJsonModal = true" 
            class="btn-cal-primary"
        >
            <span>Build Form</span>
            <svg style="height:14px; width:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
            </svg>
        </button>
    </div>

    {{-- MAIN LAYOUT: Scrollable canvas + Fixed sidebar --}}
    <div style="display: flex; min-height: calc(100vh - 64px); padding-top: 64px;">

        {{-- LEFT: Scrollable canvas area --}}
        <div class="fb-canvas-scroll premium-scrollbar" style="flex: 1; padding: 1.25rem;">
            
            {{-- Canvas: Builder Mode --}}
            <div x-show="activeViewMode === 'builder'" class="space-y-4 max-w-4xl mx-auto">
                
                <!-- Form Canvas Container -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="border-b border-gray-150 bg-gray-50 px-4 py-2.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex-1 flex flex-col sm:flex-row sm:items-center gap-4">
                            <!-- Form Title Input Group -->
                            <div class="flex items-center space-x-1.5">
                                <span class="text-[13px] uppercase font-bold text-gray-400 select-none" style="font-size: 13px !important; line-height: 1 !important; display: inline-flex; align-items: center; height: 18px !important;">Form Name:</span>
                                <input 
                                    type="text" 
                                    x-model="title" 
                                    @change="saveState()"
                                    maxlength="200"
                                    placeholder="Enter Form Title..." 
                                    class="canvas-header-input font-semibold text-gray-800"
                                    style="font-size: 13px !important; line-height: 1 !important; border: none !important; background: transparent !important; box-shadow: none !important; padding: 0 !important; height: 18px !important; width: auto !important; min-width: 180px; margin: 0 !important; display: inline-flex; align-items: center;"
                                />
                            </div>
                            <!-- Vertical Divider -->
                            <span class="hidden sm:inline-block h-4 w-px bg-gray-300"></span>
                            <!-- Submission Target URL Group -->
                            <div class="flex items-center space-x-1.5">
                                <span class="text-[13px] uppercase font-bold text-gray-400 select-none" style="font-size: 13px !important; line-height: 1 !important; display: inline-flex; align-items: center; height: 18px !important;">Target URL:</span>
                                <input 
                                    type="text" 
                                    x-model="submissionUrl" 
                                    @change="saveState()"
                                    placeholder="/submit-form" 
                                    class="canvas-header-input font-mono text-gray-600"
                                    style="font-size: 13px !important; line-height: 1 !important; border: none !important; background: transparent !important; box-shadow: none !important; padding: 0 !important; height: 18px !important; width: auto !important; min-width: 180px; margin: 0 !important; display: inline-flex; align-items: center;"
                                />
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 text-[11px] text-gray-400 font-medium">
                            <span x-text="fields.length + ' fields'"></span>
                        </div>
                    </div>

                    <!-- Drop area -->
                    <div 
                        id="canvas-fields" 
                        class="p-4 min-h-[480px] space-y-3 transition-colors"
                        :class="fields.length === 0 ? 'flex flex-col items-center justify-center border-2 border-dashed border-gray-200 m-4 rounded-xl bg-gray-50/50' : ''"
                    >
                        <!-- Empty state -->
                        <div x-show="fields.length === 0" class="text-center p-8 flex flex-col items-center select-none">
                            <div class="p-3.5 bg-gray-50 border border-gray-200 rounded-full text-gray-600 mb-4">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900">Your form is empty</h3>
                            <p class="text-sm text-gray-500 mt-1 max-w-xs leading-relaxed">Drag components from the sidebar here or click them to build your custom form layout.</p>
                        </div>

                        <!-- Fields Loop -->
                        <template x-for="(field, index) in fields" :key="field.id">
                            <div 
                                :data-id="field.id"
                                :data-index="index"
                                @click="selectField(field)"
                                class="placed-field-wrapper flex overflow-hidden border rounded-xl shadow-sm hover:shadow-md transition-all cursor-pointer select-none group"
                                :class="activeField && activeField.id === field.id ? 'border-gray-900 ring-2 ring-gray-900/10 bg-gray-50/20' : 'border-gray-200 bg-white hover:border-gray-300'"
                            >
                                <!-- Drag Handle: Full height on the left -->
                                <div class="drag-handle w-8 flex-shrink-0 flex items-center justify-center bg-gray-50 border-r border-gray-150 hover:bg-gray-100 transition-colors cursor-grab active:cursor-grabbing text-gray-400 hover:text-gray-700">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                                    </svg>
                                </div>

                                <!-- Card Content Area (Right) -->
                                <div class="flex-1 p-3.5 relative">
                                    <!-- Field Header Actions & Details -->
                                    <div class="flex items-center justify-between mb-2.5 border-b border-gray-100 pb-1.5">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-[9px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-gray-100 text-gray-750 font-mono" x-text="field.type"></span>
                                            <template x-if="field.layoutType">
                                                <span class="text-[9px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-gray-50 border border-gray-200 text-gray-600 font-mono" x-text="field.layoutType"></span>
                                            </template>
                                        </div>

                                        <!-- Card Actions -->
                                        <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button 
                                                @click.stop="duplicateField(field)" 
                                                type="button"
                                                class="p-1 hover:bg-gray-100 rounded text-gray-500 hover:text-gray-900 transition-colors"
                                                title="Duplicate Field"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                                </svg>
                                            </button>
                                            <button 
                                                @click.stop="deleteField(field.id)" 
                                                type="button"
                                                class="p-1 hover:bg-red-50 rounded text-red-650 hover:text-red-700 transition-colors"
                                                title="Delete Field"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Server Rendered blade component content -->
                                    <div class="pointer-events-none">
                                    <div x-show="field.type === 'text'">
                                        <x-fields.text :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'textarea'">
                                        <x-fields.textarea :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'number'">
                                        <x-fields.number :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'email'">
                                        <x-fields.email :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'phone'">
                                        <x-fields.phone :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'dropdown'">
                                        <x-fields.dropdown :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'radio'">
                                        <x-fields.radio :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'checkbox'">
                                        <x-fields.checkbox :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'datepicker'">
                                        <x-fields.datepicker :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'fileupload'">
                                        <x-fields.fileupload :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'layout'">
                                        <x-fields.layout :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'hidden'">
                                        <x-fields.hidden :is-builder="true" />
                                    </div>
                                    <div x-show="field.type === 'location'">
                                        <x-fields.location :is-builder="true" />
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- INTERACTIVE PREVIEW (Active when view mode = preview) -->
            <div x-show="activeViewMode === 'preview'" class="max-w-4xl mx-auto">
                <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm">
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900" style="letter-spacing: -0.3px;" x-text="title || 'Untitled Form'"></h2>
                        <span class="text-xs text-gray-400 font-mono" x-text="'POST target: ' + submissionUrl"></span>
                    </div>

                    <!-- Loader spinner -->
                    <div x-show="previewLoading" class="flex flex-col items-center justify-center py-20">
                        <svg class="animate-spin h-7 w-7 text-gray-900 mb-3" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-xs font-semibold text-gray-500">Compiling and rendering blade form elements...</p>
                    </div>

                    <!-- Interactive content loaded dynamically -->
                    <div x-show="!previewLoading" x-html="previewHtml"></div>
                </div>
            </div>
        </div>{{-- end .fb-canvas-scroll --}}

        {{-- RIGHT: Fixed sidebar --}}
        <div class="fb-sidebar-fixed premium-scrollbar bg-white shadow-sm">
            <!-- Tabs navigation -->
            <div class="grid grid-cols-2 border-b border-gray-200 bg-gray-50">
                <button 
                    @click="activeSidebarTab = 'add'"
                    :class="activeSidebarTab === 'add' ? 'border-b-2 border-gray-900 bg-white text-gray-900 font-bold' : 'text-gray-500 hover:bg-gray-100 font-medium'"
                    class="py-3.5 text-center text-xs transition-all focus:outline-none"
                >
                    Add Fields
                </button>
                <button 
                    @click="activeSidebarTab = 'edit'"
                    :class="activeSidebarTab === 'edit' ? 'border-b-2 border-gray-900 bg-white text-gray-900 font-bold' : 'text-gray-500 hover:bg-gray-100 font-medium'"
                    class="py-3.5 text-center text-xs transition-all focus:outline-none"
                >
                    Field Options
                </button>
            </div>

            <!-- Tab: Add Fields -->
            <div x-show="activeSidebarTab === 'add'" class="p-6 space-y-6">
                <p class="text-xs text-gray-500 font-medium leading-relaxed">Drag components directly onto the canvas, or click them to append to the bottom of the list.</p>
                
                <div id="sidebar-fields" class="grid grid-cols-2 gap-3">
                    <!-- Text Input -->
                    <div 
                        data-type="text"
                        @click="addField('text')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h11" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Text Input</span>
                    </div>

                    <!-- Textarea -->
                    <div 
                        data-type="textarea"
                        @click="addField('textarea')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16M4 6v12M20 6v12" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Text Area</span>
                    </div>

                    <!-- Number -->
                    <div 
                        data-type="number"
                        @click="addField('number')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Number Input</span>
                    </div>

                    <!-- Email -->
                    <div 
                        data-type="email"
                        @click="addField('email')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L22 8m-2 11H4a2 2 0 01-2-2V7a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Email</span>
                    </div>

                    <!-- Phone -->
                    <div 
                        data-type="phone"
                        @click="addField('phone')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Phone</span>
                    </div>

                    <!-- Dropdown Select -->
                    <div 
                        data-type="dropdown"
                        @click="addField('dropdown')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Dropdown</span>
                    </div>

                    <!-- Radio Buttons -->
                    <div 
                        data-type="radio"
                        @click="addField('radio')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <circle cx="12" cy="12" r="10" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="currentColor"/>
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Radio Group</span>
                    </div>

                    <!-- Checkbox -->
                    <div 
                        data-type="checkbox"
                        @click="addField('checkbox')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Checkbox</span>
                    </div>

                    <!-- Date Picker -->
                    <div 
                        data-type="datepicker"
                        @click="addField('datepicker')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Date Selection</span>
                    </div>

                    <!-- File Upload -->
                    <div 
                        data-type="fileupload"
                        @click="addField('fileupload')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">File Upload</span>
                    </div>

                    <!-- Layout Element -->
                    <div 
                        data-type="layout"
                        @click="addField('layout')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2z" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Layout Block</span>
                    </div>

                    <!-- Hidden Field -->
                    <div 
                        data-type="hidden"
                        @click="addField('hidden')"
                        class="p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex flex-col items-center justify-center text-center cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm mb-2.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Hidden Field</span>
                    </div>

                    <!-- Location -->
                    <div 
                        data-type="location"
                        @click="addField('location')"
                        class="col-span-2 p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-900 rounded-lg flex items-center justify-center space-x-3 cursor-pointer transition-all duration-150 active:scale-95 group hover:-translate-y-0.5 shadow-sm"
                    >
                        <span class="p-2 bg-white rounded-md text-gray-600 group-hover:text-gray-900 transition-colors shadow-sm">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-800">Location Picker</span>
                    </div>
                </div>
            </div>

            <!-- Tab: Field Options -->
            <div x-show="activeSidebarTab === 'edit'" class="p-6 space-y-6 premium-scrollbar">
                
                <!-- If no field active -->
                <div x-show="!activeField" class="text-center py-12 flex flex-col items-center">
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-full text-gray-400 mb-3.5">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-semibold text-gray-800">No Field Selected</h4>
                    <p class="text-xs text-gray-500 mt-1 max-w-[200px] mx-auto leading-relaxed">Select any field in the canvas to view and customize its properties.</p>
                </div>

                <!-- If field active -->
                <template x-if="activeField">
                    <div class="space-y-5">
                        
                        <!-- Field Type indicator -->
                        <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-between">
                            <span class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Field settings</span>
                            <span class="text-[10px] bg-gray-900 text-white font-bold px-2.5 py-0.5 rounded-full uppercase" x-text="activeField.type"></span>
                        </div>

                        <!-- 1. Layout Fields specific controls -->
                        <template x-if="activeField && activeField.type === 'layout'">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Layout Element Type</label>
                                    <select 
                                        x-model="activeField.layoutType"
                                        @change="
                                            if (activeField.layoutType === 'title') { activeField.label = 'Title Header'; } 
                                            else if (activeField.layoutType === 'description') { activeField.placeholder = 'Enter description text here...'; }; 
                                            pushToHistory()
                                        "
                                        class="w-full"
                                    >
                                        <option value="title">Title Header</option>
                                        <option value="description">Description Text</option>
                                        <option value="newline">New Line Break</option>
                                        <option value="pagebreak">Page Break</option>
                                    </select>
                                </div>
                            </div>
                        </template>

                        <!-- 2. Location Fields specific controls -->
                        <template x-if="activeField && activeField.type === 'location'">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Selector Type</label>
                                    <select 
                                        x-model="activeField.locationType"
                                        @change="pushToHistory()"
                                        class="w-full"
                                    >
                                        <option value="combined">State & City Combined</option>
                                        <option value="state">State Selector Only</option>
                                        <option value="city">City Selector Only</option>
                                    </select>
                                </div>
                            </div>
                        </template>

                        <!-- Common Attribute: Label (Except Newline / Pagebreak) -->
                        <template x-if="activeField && activeField.type !== 'hidden' && !(activeField.type === 'layout' && (activeField.layoutType === 'newline' || activeField.layoutType === 'pagebreak'))">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2" x-text="activeField.type === 'layout' ? 'Header Title Text' : 'Field Label'"></label>
                                <input 
                                    type="text" 
                                    x-model="activeField.label" 
                                    @change="pushToHistory()"
                                    class="w-full"
                                />
                            </div>
                        </template>

                        <!-- Common Attribute: Name (Key) (Inputs only) -->
                        <template x-if="activeField && activeField.type !== 'layout'">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Field Name (API / JSON Key)</label>
                                <input 
                                    type="text" 
                                    x-model="activeField.name" 
                                    @change="pushToHistory()"
                                    placeholder="e.g. text_input"
                                    class="w-full font-mono text-xs"
                                />
                            </div>
                        </template>

                        <!-- Common Attribute: Placeholder (Inputs & description Layout) -->
                        <template x-if="activeField && (['text', 'textarea', 'number', 'email', 'phone', 'fileupload'].includes(activeField.type) || (activeField.type === 'layout' && activeField.layoutType === 'description'))">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2" x-text="activeField.type === 'layout' ? 'Description Markdown/Text' : 'Placeholder Text'"></label>
                                <template x-if="activeField.type === 'textarea' || (activeField.type === 'layout' && activeField.layoutType === 'description')">
                                    <textarea 
                                        x-model="activeField.placeholder" 
                                        @change="pushToHistory()"
                                        class="w-full text-xs"
                                        rows="3"
                                    ></textarea>
                                </template>
                                <template x-if="activeField.type !== 'textarea' && !(activeField.type === 'layout' && activeField.layoutType === 'description')">
                                    <input 
                                        type="text" 
                                        x-model="activeField.placeholder" 
                                        @change="pushToHistory()"
                                        class="w-full"
                                    />
                                </template>
                            </div>
                        </template>

                        <!-- Common Attribute: Default Value (Inputs only) -->
                        <template x-if="activeField && ['text', 'textarea', 'number', 'email', 'phone', 'datepicker', 'hidden'].includes(activeField.type)">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Default Pre-filled Value</label>
                                <template x-if="activeField.type === 'datepicker'">
                                    <input 
                                        type="date" 
                                        x-model="activeField.defaultValue" 
                                        @change="pushToHistory()"
                                        class="w-full"
                                    />
                                </template>
                                <template x-if="activeField.type === 'textarea'">
                                    <textarea 
                                        x-model="activeField.defaultValue" 
                                        @change="pushToHistory()"
                                        class="w-full text-xs"
                                        rows="3"
                                    ></textarea>
                                </template>
                                <template x-if="activeField.type !== 'datepicker' && activeField.type !== 'textarea'">
                                    <input 
                                        type="text" 
                                        x-model="activeField.defaultValue" 
                                        @change="pushToHistory()"
                                        class="w-full"
                                    />
                                </template>
                            </div>
                        </template>

                        <!-- Validation Rules: Text / Textarea min/max length -->
                        <template x-if="activeField && ['text', 'textarea'].includes(activeField.type)">
                            <div class="grid grid-cols-2 gap-4 border-t border-gray-150 pt-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Min Characters</label>
                                    <input 
                                        type="number" 
                                        x-model="activeField.minChars" 
                                        @change="pushToHistory()"
                                        placeholder="None"
                                        class="w-full text-center"
                                    />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Max Characters</label>
                                    <input 
                                        type="number" 
                                        x-model="activeField.maxChars" 
                                        @change="pushToHistory()"
                                        placeholder="None"
                                        class="w-full text-center"
                                    />
                                </div>
                            </div>
                        </template>

                        <!-- Validation Rules: File Upload specific (Size & Extensions) -->
                        <template x-if="activeField && activeField.type === 'fileupload'">
                            <div class="space-y-4 border-t border-gray-150 pt-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Max Allowed Size (MB)</label>
                                    <input 
                                        type="number" 
                                        x-model="activeField.maxFileSize" 
                                        @change="pushToHistory()"
                                        placeholder="e.g. 5"
                                        class="w-full"
                                    />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Allowed File Extensions</label>
                                    <input 
                                        type="text" 
                                        x-model="activeField.allowedExtensions" 
                                        @change="pushToHistory()"
                                        placeholder="e.g. .jpg,.png,.pdf"
                                        class="w-full font-mono text-xs"
                                    />
                                </div>
                            </div>
                        </template>

                        <!-- Validation Rules: Datepicker min/max dates -->
                        <template x-if="activeField && activeField.type === 'datepicker'">
                            <div class="grid grid-cols-2 gap-4 border-t border-gray-150 pt-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Min Date limit</label>
                                    <input 
                                        type="date" 
                                        x-model="activeField.minDate" 
                                        @change="pushToHistory()"
                                        class="w-full text-xs"
                                    />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Max Date limit</label>
                                    <input 
                                        type="date" 
                                        x-model="activeField.maxDate" 
                                        @change="pushToHistory()"
                                        class="w-full text-xs"
                                    />
                                </div>
                            </div>
                        </template>

                        <!-- Option list editor (Dropdown, Radio, Checkbox) -->
                        <template x-if="activeField && ['dropdown', 'radio', 'checkbox'].includes(activeField.type)">
                            <div class="border-t border-gray-150 pt-4 space-y-3">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Manage List Options</label>
                                
                                <div class="space-y-2">
                                    <template x-for="(opt, idx) in activeField.options" :key="idx">
                                        <div class="flex items-center space-x-2">
                                            <input 
                                                type="text" 
                                                :value="opt"
                                                @change="
                                                    activeField.options[idx] = $el.value; 
                                                    pushToHistory()
                                                "
                                                class="w-full text-xs"
                                            />
                                            <button 
                                                @click="
                                                    activeField.options.splice(idx, 1); 
                                                    pushToHistory()
                                                " 
                                                type="button"
                                                class="p-2 hover:bg-red-50 text-red-650 hover:text-red-700 rounded transition-colors"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <button 
                                    type="button" 
                                    @click="
                                        if(!activeField.options) activeField.options = [];
                                        activeField.options.push('New Option ' + (activeField.options.length + 1)); 
                                        pushToHistory()
                                    "
                                    class="btn-cal-secondary w-full"
                                >
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Add Choice Option</span>
                                </button>

                                <!-- Default selection checkboxes for Checkboxes field -->
                                <template x-if="activeField.type === 'checkbox'">
                                    <div class="space-y-2 mt-4 pt-4 border-t border-gray-150">
                                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Pre-Checked Default Options</label>
                                        <div class="space-y-1.5 flex flex-col">
                                            <template x-for="opt in activeField.options" :key="opt">
                                                <label class="inline-flex items-center text-xs font-semibold text-gray-700 cursor-pointer select-none">
                                                    <input 
                                                        type="checkbox"
                                                        :checked="activeField.defaultValues && activeField.defaultValues.includes(opt)"
                                                        @change="
                                                            if (!activeField.defaultValues) activeField.defaultValues = [];
                                                            if ($el.checked) {
                                                                if (!activeField.defaultValues.includes(opt)) activeField.defaultValues.push(opt);
                                                            } else {
                                                                activeField.defaultValues = activeField.defaultValues.filter(v => v !== opt);
                                                            }
                                                            pushToHistory();
                                                        "
                                                        class="rounded border-gray-300 text-gray-900 focus:ring-gray-900 mr-2 h-4.5 w-4.5"
                                                        style="height: 16px !important; width: 16px !important; border: 1px solid var(--colors-hairline) !important; accent-color: var(--colors-ink) !important;"
                                                    />
                                                    <span x-text="opt"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <!-- Common Attribute: CSS Width Class (Except Hidden field) -->
                        <template x-if="activeField && activeField.type !== 'hidden'">
                            <div class="border-t border-gray-150 pt-4">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-3">Element Span Grid Width</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <button 
                                        type="button" 
                                        @click="activeField.class = 'col-span-1'; pushToHistory()"
                                        :class="activeField.class === 'col-span-1' ? 'bg-gray-900 text-white shadow-sm' : 'bg-white text-gray-900 hover:bg-gray-50 border border-gray-200'"
                                        class="py-2.5 rounded-lg text-xs font-bold transition-all text-center focus:outline-none"
                                    >
                                        Half Width (50%)
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="activeField.class = 'col-span-2'; pushToHistory()"
                                        :class="activeField.class === 'col-span-2' || !activeField.class ? 'bg-gray-900 text-white shadow-sm' : 'bg-white text-gray-900 hover:bg-gray-50 border border-gray-200'"
                                        class="py-2.5 rounded-lg text-xs font-bold transition-all text-center focus:outline-none"
                                    >
                                        Full Width (100%)
                                    </button>
                                </div>
                            </div>
                        </template>

                        <!-- Common Attribute: Required (Inputs only) -->
                        <template x-if="activeField && !['layout', 'hidden'].includes(activeField.type)">
                            <div class="flex items-center justify-between border-t border-gray-150 pt-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Mandatory Field</label>
                                    <span class="text-[10px] text-gray-400">Users cannot submit form without filling this</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer select-none">
                                    <input 
                                        type="checkbox" 
                                        x-model="activeField.required" 
                                        @change="pushToHistory()"
                                        class="sr-only peer"
                                    />
                                    <div class="w-10 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gray-900"></div>
                                </label>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>{{-- end .fb-sidebar-fixed --}}
    </div>{{-- end flex layout --}}

    <!-- EXPORT MODAL -->
    <div 
        x-show="showJsonModal" 
        class="fixed inset-0 z-[1100] overflow-y-auto" 
        style="display: none;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay background -->
            <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" @click="showJsonModal = false"></div>

            <!-- Center elements trick -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <!-- Modal contents -->
            <div 
                class="inline-block align-middle bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-gray-200"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-b border-gray-200">
                    <div class="flex items-center space-x-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Export Form JSON Schema</span>
                    </div>
                    <button @click="showJsonModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4 bg-white">
                    <div class="flex items-center justify-between text-xs font-medium text-gray-500">
                        <span>JSON representation of the constructed form. Copy this directly to parse anywhere.</span>
                        <button 
                            @click="copyJsonToClipboard()" 
                            class="px-3 py-1.5 bg-white hover:bg-gray-100 text-gray-900 rounded text-xs font-semibold transition-all shadow-sm flex items-center space-x-1 border border-gray-200"
                        >
                            <template x-if="!clipboardCopied">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </template>
                            <template x-if="clipboardCopied">
                                <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </template>
                            <span x-text="clipboardCopied ? 'Copied!' : 'Copy to Clipboard'"></span>
                        </button>
                    </div>

                    <!-- JSON Pre block -->
                    <div class="relative">
                        <pre class="premium-scrollbar text-xs text-gray-700 p-5 bg-gray-50 border border-gray-200 rounded-lg overflow-x-auto max-h-[400px] font-mono leading-relaxed" x-text="JSON.stringify({ title, submissionUrl, fields }, null, 4)"></pre>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 flex justify-end border-t border-gray-200">
                    <button 
                        type="button" 
                        @click="showJsonModal = false"
                        class="btn-cal-primary"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function formBuilder() {
        return {
            fields: [],
            activeField: null,
            title: 'My Custom Form',
            submissionUrl: '/submit-form',
            activeSidebarTab: 'add',
            activeViewMode: 'builder',
            sidebarOpen: true,
            undoStack: [],
            redoStack: [],
            previewHtml: '',
            previewLoading: false,
            showJsonModal: false,
            clipboardCopied: false,

            init() {
                // Try reading from LocalStorage
                const savedTitle = localStorage.getItem('form_title');
                const savedUrl = localStorage.getItem('form_submission_url');
                const savedFields = localStorage.getItem('form_fields');

                if (savedTitle) this.title = savedTitle;
                if (savedUrl) this.submissionUrl = savedUrl;
                if (savedFields) {
                    try {
                        this.fields = JSON.parse(savedFields);
                    } catch (e) {
                        this.fields = [];
                    }
                }

                // Default initial fields to guide the user
                if (this.fields.length === 0) {
                    this.fields = [
                        {
                            id: 'field_init_text',
                            type: 'text',
                            label: 'Full Name',
                            name: 'full_name',
                            placeholder: 'Enter your name...',
                            required: true,
                            defaultValue: '',
                            class: 'col-span-2',
                            minChars: '',
                            maxChars: ''
                        },
                        {
                            id: 'field_init_email',
                            type: 'email',
                            label: 'Email Address',
                            name: 'email',
                            placeholder: 'name@example.com',
                            required: true,
                            defaultValue: '',
                            class: 'col-span-1'
                        },
                        {
                            id: 'field_init_phone',
                            type: 'phone',
                            label: 'Phone Number',
                            name: 'phone_number',
                            placeholder: '+1 (555) 000-0000',
                            required: false,
                            defaultValue: '',
                            class: 'col-span-1'
                        }
                    ];
                    this.saveState(false);
                }

                // Initialize SortableJS
                this.$nextTick(() => {
                    const canvasEl = document.getElementById('canvas-fields');
                    if (canvasEl) {
                        Sortable.create(canvasEl, {
                            group: 'shared-form-builder',
                            handle: '.drag-handle',
                            animation: 150,
                            ghostClass: 'ghost-class',
                            onEnd: (evt) => {
                                if (evt.oldIndex !== evt.newIndex) {
                                    this.pushToHistory();
                                    const movedItem = this.fields.splice(evt.oldIndex, 1)[0];
                                    this.fields.splice(evt.newIndex, 0, movedItem);
                                    this.saveState(false);
                                }
                            }
                        });
                    }

                    const sidebarEl = document.getElementById('sidebar-fields');
                    if (sidebarEl) {
                        Sortable.create(sidebarEl, {
                            group: {
                                name: 'shared-form-builder',
                                pull: 'clone',
                                put: false
                            },
                            sort: false,
                            animation: 150,
                            onEnd: (evt) => {
                                if (evt.to === canvasEl) {
                                    const type = evt.item.getAttribute('data-type');
                                    const newIndex = evt.newIndex;
                                    evt.item.remove();
                                    this.addField(type, newIndex);
                                }
                            }
                        });
                    }
                });

                // Attach Undo / Redo keyboard shortcuts
                window.addEventListener('keydown', (e) => {
                    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'z') {
                        e.preventDefault();
                        this.undo();
                    }
                    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'y') {
                        e.preventDefault();
                        this.redo();
                    }
                });
            },

            pushToHistory() {
                // Max history buffer 50 entries
                if (this.undoStack.length >= 50) {
                    this.undoStack.shift();
                }
                this.undoStack.push(JSON.stringify(this.fields));
                this.redoStack = []; // Clear redo stack on action
            },

            saveState(shouldPushHistory = true) {
                if (shouldPushHistory) {
                    this.pushToHistory();
                }
                localStorage.setItem('form_title', this.title);
                localStorage.setItem('form_submission_url', this.submissionUrl);
                localStorage.setItem('form_fields', JSON.stringify(this.fields));
            },

            addField(type, index = null) {
                this.pushToHistory();
                const newField = this.createNewFieldObject(type);
                
                if (index !== null) {
                    this.fields.splice(index, 0, newField);
                } else {
                    this.fields.push(newField);
                }

                this.activeField = newField;
                this.activeSidebarTab = 'edit';
                this.saveState(false);
            },

            deleteField(id) {
                this.pushToHistory();
                this.fields = this.fields.filter(f => f.id !== id);
                if (this.activeField && this.activeField.id === id) {
                    this.activeField = null;
                    this.activeSidebarTab = 'add';
                }
                this.saveState(false);
            },

            duplicateField(field) {
                this.pushToHistory();
                const clone = JSON.parse(JSON.stringify(field));
                clone.id = 'field_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
                clone.name = clone.name + '_copy';
                if (clone.label) clone.label = clone.label + ' (Copy)';

                const origIndex = this.fields.findIndex(f => f.id === field.id);
                if (origIndex !== -1) {
                    this.fields.splice(origIndex + 1, 0, clone);
                } else {
                    this.fields.push(clone);
                }

                this.activeField = clone;
                this.activeSidebarTab = 'edit';
                this.saveState(false);
            },

            selectField(field) {
                this.activeField = field;
                this.activeSidebarTab = 'edit';
            },

            clearCanvas() {
                if (confirm('Are you sure you want to clear all form fields? This cannot be undone.')) {
                    this.pushToHistory();
                    this.fields = [];
                    this.activeField = null;
                    this.activeSidebarTab = 'add';
                    this.saveState(false);
                }
            },

            undo() {
                if (this.undoStack.length > 0) {
                    this.redoStack.push(JSON.stringify(this.fields));
                    const prevState = this.undoStack.pop();
                    this.fields = JSON.parse(prevState);
                    this.activeField = null; // deselect active to prevent binding issues
                    this.saveState(false);
                }
            },

            redo() {
                if (this.redoStack.length > 0) {
                    this.undoStack.push(JSON.stringify(this.fields));
                    const nextState = this.redoStack.pop();
                    this.fields = JSON.parse(nextState);
                    this.activeField = null;
                    this.saveState(false);
                }
            },

            toggleViewMode(mode) {
                this.activeViewMode = mode;
                if (mode === 'preview') {
                    this.loadPreview();
                }
            },

            loadPreview() {
                this.previewLoading = true;
                
                // Fetch dynamic rendered Blade form fields from Laravel server
                fetch('{{ route("interview.assessment") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        schema: this.fields
                    })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Preview generation failed');
                    return res.json();
                })
                .then(data => {
                    this.previewHtml = data.html;
                })
                .catch(err => {
                    console.error(err);
                    this.previewHtml = `<div class="p-6 bg-red-50 text-red-650 border border-red-200 rounded-xl">
                        <h4 class="font-bold">Error loading live preview</h4>
                        <p class="text-sm mt-1">Failed to contact the server to compile Blade component elements.</p>
                    </div>`;
                })
                .finally(() => {
                    this.previewLoading = false;
                });
            },

            copyJsonToClipboard() {
                const schema = {
                    title: this.title,
                    submissionUrl: this.submissionUrl,
                    fields: this.fields
                };
                const jsonText = JSON.stringify(schema, null, 4);
                
                navigator.clipboard.writeText(jsonText)
                    .then(() => {
                        this.clipboardCopied = true;
                        setTimeout(() => {
                            this.clipboardCopied = false;
                        }, 2500);
                    })
                    .catch(err => {
                        console.error('Failed to copy text: ', err);
                    });
            },

            createNewFieldObject(type) {
                const uniqueId = 'field_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
                const base = {
                    id: uniqueId,
                    type: type,
                    label: '',
                    name: type + '_' + Math.random().toString(36).substr(2, 4),
                    required: false,
                    class: 'col-span-2'
                };

                switch (type) {
                    case 'text':
                        base.label = 'Text Input';
                        base.placeholder = 'Enter text...';
                        base.defaultValue = '';
                        base.minChars = '';
                        base.maxChars = '';
                        break;
                    case 'textarea':
                        base.label = 'Text Area';
                        base.placeholder = 'Enter detailed text...';
                        base.defaultValue = '';
                        base.minChars = '';
                        base.maxChars = '';
                        break;
                    case 'number':
                        base.label = 'Number Input';
                        base.placeholder = 'Enter number...';
                        base.defaultValue = '';
                        break;
                    case 'email':
                        base.label = 'Email Input';
                        base.placeholder = 'name@example.com';
                        base.defaultValue = '';
                        break;
                    case 'phone':
                        base.label = 'Phone Input';
                        base.placeholder = '+1 (555) 000-0000';
                        base.defaultValue = '';
                        break;
                    case 'dropdown':
                        base.label = 'Dropdown Select';
                        base.placeholder = 'Select an option...';
                        base.options = ['Option 1', 'Option 2', 'Option 3'];
                        base.class = 'col-span-1';
                        break;
                    case 'radio':
                        base.label = 'Radio Group';
                        base.options = ['Option 1', 'Option 2', 'Option 3'];
                        base.defaultValue = 'Option 1';
                        base.class = 'col-span-1';
                        break;
                    case 'checkbox':
                        base.label = 'Checkbox Group';
                        base.options = ['Option 1', 'Option 2', 'Option 3'];
                        base.defaultValues = [];
                        base.class = 'col-span-1';
                        break;
                    case 'datepicker':
                        base.label = 'Date Selection';
                        base.defaultValue = '';
                        base.minDate = '';
                        base.maxDate = '';
                        base.class = 'col-span-1';
                        break;
                    case 'fileupload':
                        base.label = 'File Upload';
                        base.placeholder = 'Choose a file...';
                        base.maxFileSize = '5';
                        base.allowedExtensions = '.jpg,.png,.pdf';
                        break;
                    case 'layout':
                        base.label = 'Title Header';
                        base.placeholder = '';
                        base.layoutType = 'title';
                        break;
                    case 'hidden':
                        base.name = 'hidden_' + Math.random().toString(36).substr(2, 4);
                        base.defaultValue = 'default_value';
                        break;
                    case 'location':
                        base.label = 'Location';
                        base.locationType = 'combined'; // state, city, combined
                        break;
                }

                return base;
            }
        };
    }
</script>
@endsection