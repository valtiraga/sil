<div>
    <button
        wire:click="switchLocale"
        type="button"
        class="language-toggle-btn"
        title="{{ $currentLocale === 'en' ? 'Switch to Indonesian' : 'Switch to English' }}"
    >
        <span class="toggle-track">
            <span class="toggle-label toggle-label--en {{ $currentLocale === 'en' ? 'active' : '' }}">EN</span>
            <span class="toggle-label toggle-label--id {{ $currentLocale === 'id' ? 'active' : '' }}">ID</span>
            <span class="toggle-knob {{ $currentLocale === 'id' ? 'toggle-knob--right' : '' }}"></span>
        </span>
    </button>

    <style>
        .language-toggle-btn {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            outline: none;
            display: inline-flex;
            align-items: center;
        }

        .toggle-track {
            position: relative;
            display: inline-flex;
            align-items: center;
            width: 64px;
            height: 30px;
            border-radius: 15px;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            padding: 2px;
            transition: background 0.3s ease;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(255, 255, 255, 0.8);
        }

        .dark .toggle-track {
            background: linear-gradient(135deg, #374151, #4b5563);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px 2px rgba(255, 255, 255, 0.05);
        }

        .toggle-label {
            position: relative;
            z-index: 2;
            width: 50%;
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
            line-height: 26px;
            color: #94a3b8;
            transition: color 0.3s ease;
            user-select: none;
        }

        .toggle-label.active {
            color: #ffffff;
        }

        .dark .toggle-label {
            color: #6b7280;
        }

        .dark .toggle-label.active {
            color: #ffffff;
        }

        .toggle-knob {
            position: absolute;
            top: 2px;
            left: 2px;
            width: calc(50% - 2px);
            height: calc(100% - 4px);
            border-radius: 13px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            box-shadow: 0 2px 6px rgba(220, 38, 38, 0.4), 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-knob--right {
            transform: translateX(100%);
        }

        .language-toggle-btn:hover .toggle-track {
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.15), 0 2px 4px rgba(220, 38, 38, 0.15);
        }

        .language-toggle-btn:active .toggle-knob {
            width: calc(55% - 2px);
        }

        .language-toggle-btn:active .toggle-knob--right {
            transform: translateX(82%);
        }

        .language-toggle-btn:focus-visible .toggle-track {
            outline: 2px solid #dc2626;
            outline-offset: 2px;
        }
    </style>
</div>
