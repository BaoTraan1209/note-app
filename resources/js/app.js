import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

/* PASSWORD TOGGLE */
document.querySelectorAll("[data-password-toggle]").forEach((button) => {
    button.addEventListener("click", () => {
        const input = document.querySelector(`#${button.dataset.target}`);

        if (!input) return;

        const isPassword = input.type === "password";

        input.type = isPassword ? "text" : "password";

        button.setAttribute(
            "aria-label",
            isPassword ? "Hide password" : "Show password"
        );

        button.innerHTML = isPassword
            ? '<i class="bi bi-eye-slash"></i>'
            : '<i class="bi bi-eye"></i>';
    });
});

/* LOADING FORM */

document.querySelectorAll("[data-loading-form]").forEach((form) => {
    form.addEventListener("submit", () => {
        const button = form.querySelector("button[type='submit']");

        if (!button) return;

        button.style.opacity = "0.8";
        button.style.pointerEvents = "none";
    });
});

/* =========================================================
   CONFIRM MODAL
========================================================= */

const confirmModal = document.querySelector("[data-confirm-modal]");
const confirmMessage = document.querySelector("[data-confirm-message]");
const confirmAccept = document.querySelector("[data-confirm-accept]");
const confirmCancel = document.querySelector("[data-confirm-cancel]");

let pendingConfirmForm = null;

function closeConfirmModal() {
    confirmModal?.classList.remove("is-open");
    confirmModal?.setAttribute("aria-hidden", "true");

    pendingConfirmForm = null;
}

document.querySelectorAll("[data-confirm]").forEach((form) => {
    form.addEventListener("submit", (event) => {
        if (form.dataset.confirmed === "true") {
            form.dataset.confirmed = "false";
            return;
        }

        event.preventDefault();

        pendingConfirmForm = form;

        if (confirmMessage) {
            confirmMessage.textContent =
                form.dataset.confirm || "Are you sure?";
        }

        confirmModal?.classList.add("is-open");
        confirmModal?.setAttribute("aria-hidden", "false");
    });
});

confirmAccept?.addEventListener("click", () => {
    if (!pendingConfirmForm) return;

    pendingConfirmForm.dataset.confirmed = "true";
    pendingConfirmForm.requestSubmit();

    closeConfirmModal();
});

confirmCancel?.addEventListener("click", closeConfirmModal);

confirmModal?.addEventListener("click", (event) => {
    if (event.target === confirmModal) {
        closeConfirmModal();
    }
});

/* =========================================================
   CUSTOM SELECTS
========================================================= */

function closeCustomSelects(except = null) {
    document.querySelectorAll("[data-custom-select]").forEach((select) => {
        if (select !== except) {
            select.classList.remove("is-open");
            select.closest(".share-row")?.classList.remove("has-open-select");
            select
                .querySelector(".custom-select-button")
                ?.setAttribute("aria-expanded", "false");
        }
    });
}

function enhanceFilterSelect(select) {
    if (select.dataset.customSelectReady === "true") return;

    select.dataset.customSelectReady = "true";

    const wrapper = document.createElement("div");
    wrapper.className = "custom-select";
    wrapper.dataset.customSelect = "";

    const button = document.createElement("button");
    button.className = "custom-select-button";
    button.type = "button";
    button.setAttribute("aria-haspopup", "listbox");
    button.setAttribute("aria-expanded", "false");

    const selectedText = document.createElement("span");
    selectedText.className = "custom-select-text";

    const menu = document.createElement("div");
    menu.className = "custom-select-menu";
    menu.setAttribute("role", "listbox");

    button.appendChild(selectedText);

    select.parentNode.insertBefore(wrapper, select);
    wrapper.append(select, button, menu);
    select.classList.add("filter-select-native");

    function selectedOption() {
        return select.selectedOptions[0] || select.options[0] || null;
    }

    function render() {
        const current = selectedOption();
        selectedText.textContent = current?.textContent?.trim() || "";
        menu.innerHTML = "";

        [...select.options].forEach((option) => {
            if (option.hidden) return;
            if (option.value === "" && select.options.length > 1) return;

            const item = document.createElement("button");
            item.className = "custom-select-option";
            item.type = "button";
            item.role = "option";
            item.textContent = option.textContent;
            item.disabled = option.disabled;
            item.setAttribute("aria-selected", option.selected ? "true" : "false");

            if (option.selected) {
                item.classList.add("is-selected");
            }

            item.addEventListener("click", (event) => {
                event.stopPropagation();

                if (option.disabled) return;

                select.value = option.value;
                select.dispatchEvent(new Event("change", { bubbles: true }));
                closeCustomSelects();
                render();
            });

            menu.appendChild(item);
        });
    }

    function positionMenu() {
        const rect = wrapper.getBoundingClientRect();
        const estimatedMenuHeight = Math.min(menu.scrollHeight || 230, 230);
        const spaceBelow = window.innerHeight - rect.bottom;
        const spaceAbove = rect.top;
        const shouldOpenUp = spaceBelow < estimatedMenuHeight + 12 && spaceAbove > spaceBelow;

        wrapper.classList.toggle("opens-up", shouldOpenUp);
    }

    button.addEventListener("click", (event) => {
        event.stopPropagation();

        const willOpen = !wrapper.classList.contains("is-open");
        closeCustomSelects(wrapper);
        wrapper.classList.toggle("is-open", willOpen);
        wrapper.closest(".share-row")?.classList.toggle("has-open-select", willOpen);
        button.setAttribute("aria-expanded", willOpen ? "true" : "false");

        if (willOpen) {
            positionMenu();
        }
    });

    select.addEventListener("change", render);
    select.customSelectRefresh = render;

    render();
}

document.querySelectorAll("select.filter-select").forEach(enhanceFilterSelect);

document.addEventListener("click", () => closeCustomSelects());
window.addEventListener("resize", () => closeCustomSelects());
window.addEventListener("scroll", () => closeCustomSelects(), true);
document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
        closeCustomSelects();
    }
});

document.querySelectorAll("[data-profile-file-input]").forEach((input) => {
    input.addEventListener("change", () => {
        const label = input.closest(".field")?.querySelector("[data-file-name]");

        if (label) {
            label.textContent = input.files?.[0]?.name || "No file selected";
        }
    });
});

/* =========================================================
   PREFERENCES AUTOSAVE
========================================================= */

const preferencesForm = document.querySelector("[data-preferences-form]");
const preferencesState = document.querySelector("[data-preferences-state] span");

function setPreferencesState(message) {
    if (preferencesState) {
        preferencesState.textContent = message;
    }
}

async function savePreferences() {
    if (!preferencesForm) return;

    setPreferencesState("Saving...");

    const theme = preferencesForm.querySelector('input[name="theme"]:checked')?.value;
    document.body.classList.toggle("dark-theme", theme === "dark");

    try {
        const response = await fetch(preferencesForm.action, {
            method: "POST",
            headers: {
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            body: new FormData(preferencesForm),
        });

        if (!response.ok) throw new Error("Preference save failed");

        setPreferencesState("Saved");
    } catch (error) {
        setPreferencesState("Save failed");
    }
}

preferencesForm?.querySelectorAll("[data-preference-field]").forEach((field) => {
    field.addEventListener("change", savePreferences);
});

/* =========================================================
   SIDEBAR
========================================================= */

const sidebarToggle = document.querySelector("[data-sidebar-toggle]");

sidebarToggle?.addEventListener("click", () => {
    document.body.classList.toggle("sidebar-open");
});

/* =========================================================
   USER DROPDOWN
========================================================= */

const userMenuButton = document.querySelector("[data-user-menu]");
const userDropdown = document.querySelector("[data-user-dropdown]");

userMenuButton?.addEventListener("click", (event) => {
    event.stopPropagation();

    userDropdown?.classList.toggle("is-open");
});

document.addEventListener("click", (event) => {
    if (!event.target.closest(".user-menu")) {
        userDropdown?.classList.remove("is-open");
    }

    if (
        document.body.classList.contains("sidebar-open") &&
        !event.target.closest(".sidebar") &&
        !event.target.closest("[data-sidebar-toggle]")
    ) {
        document.body.classList.remove("sidebar-open");
    }
});

/* =========================================================
   NOTE FILTERS
========================================================= */

const notesGrid = document.querySelector("[data-notes-grid]");
const noteCards = [...document.querySelectorAll("[data-note-card]")];
const noteSearch = document.querySelector("[data-note-search]");
const labelSelect = document.querySelector("[data-label-select]");
const emptyState = document.querySelector("[data-empty-state]");

let activeStatus = "all";

function applyNoteFilters() {
    if (!noteCards.length) return;

    const keywords = (noteSearch?.value || "")
        .trim()
        .toLowerCase()
        .split(/\s+/)
        .filter(Boolean);

    const activeLabel = labelSelect?.value || "all";

    let visible = 0;

    noteCards.forEach((card) => {
        const labels = (card.dataset.labels || "")
            .split(" ")
            .filter(Boolean);

        const statuses = (card.dataset.status || "")
            .split(" ")
            .filter(Boolean);

        const haystack = (
            card.dataset.searchText ||
            card.textContent ||
            ""
        ).toLowerCase();

        const matchKeyword =
            keywords.length === 0 ||
            keywords.every((keyword) => haystack.includes(keyword));

        const matchLabel =
            activeLabel === "all" || labels.includes(activeLabel);

        const matchStatus =
            activeStatus === "all" || statuses.includes(activeStatus);

        const shouldShow =
            matchKeyword &&
            matchLabel &&
            matchStatus;

        card.classList.toggle("is-hidden", !shouldShow);

        if (shouldShow) visible += 1;
    });

    emptyState?.classList.toggle("is-hidden", visible > 0);
}

noteCards.forEach((card) => {
    card.addEventListener("click", (event) => {
        if (
            event.target.closest(
                "a, button, form, input, select, textarea, label"
            )
        ) {
            return;
        }

        const openUrl = card.dataset.openUrl;

        if (openUrl) {
            window.location.href = openUrl;
        }
    });
});

noteSearch?.addEventListener("input", applyNoteFilters);

labelSelect?.addEventListener("change", applyNoteFilters);

document.querySelectorAll("[data-status-filter]").forEach((button) => {
    button.addEventListener("click", () => {
        document
            .querySelectorAll("[data-status-filter]")
            .forEach((item) => item.classList.remove("active"));

        button.classList.add("active");

        activeStatus = button.dataset.statusFilter;

        applyNoteFilters();
    });
});

document.querySelectorAll("[data-label-filter]").forEach((button) => {
    button.addEventListener("click", () => {
        document
            .querySelectorAll("[data-label-filter]")
            .forEach((item) => item.classList.remove("active"));

        button.classList.add("active");

        if (labelSelect) {
            labelSelect.value = button.dataset.labelFilter;
        }

        applyNoteFilters();
    });
});

document.querySelectorAll("[data-view]").forEach((button) => {
    button.addEventListener("click", () => {
        document
            .querySelectorAll("[data-view]")
            .forEach((item) => item.classList.remove("active"));

        button.classList.add("active");

        notesGrid?.classList.toggle(
            "list-view",
            button.dataset.view === "list"
        );
    });
});

/* =========================================================
   NOTE EDITOR
========================================================= */

const noteForm = document.querySelector("[data-note-form]");
const richEditor = document.querySelector("[data-rich-editor]");
const contentInput = document.querySelector("[data-content-input]");
const saveState = document.querySelector("[data-save-state]");
const saveStateText = saveState?.querySelector("span");

let autosaveUrl = noteForm?.dataset.autosaveUrl || "";
let autosaveMode = noteForm?.dataset.autosaveMode || "";
let noteId = noteForm?.dataset.noteId || "";
let autosaveTimer = null;
let autosaveInProgress = false;
let autosavePending = false;
let firstDirtyAt = null;
let lastAutosaveStartedAt = 0;
let lastSavedHash = "";
let applyingRemoteUpdate = false;
let realtimeSocketId = "";
let savedEditorRange = null;
let nextPendingImageId = 1;
let pendingImageFiles = [];
let currentUploadBatch = [];

const AUTOSAVE_IDLE_DELAY = 60;
const AUTOSAVE_FAST_DELAY = 0;
const AUTOSAVE_MAX_WAIT = 120;
const AUTOSAVE_MIN_INTERVAL = 0;
const AUTOSAVE_TIMEOUT = 12000;
const NOTE_DB_NAME = "notenest-offline";
const NOTE_DB_VERSION = 1;

function updateSaveState(message, type = "") {
    if (!saveState || !saveStateText) return;

    saveStateText.textContent = message;
    saveState.classList.toggle("is-offline", type === "offline");
    saveState.classList.toggle("is-error", type === "error");
    saveState.classList.toggle("is-live", type === "live");
}

function normalizeHtml(html) {
    return html
        .replace(/&nbsp;/g, " ")
        .replace(/\s+/g, " ")
        .trim();
}

function syncRichContent() {
    if (!richEditor || !contentInput) return;

    contentInput.value = normalizeHtml(richEditor.innerHTML);
}

function saveEditorSelection() {
    if (!richEditor) return;

    const selection = window.getSelection();
    if (!selection || selection.rangeCount === 0) return;

    const range = selection.getRangeAt(0);
    if (richEditor.contains(range.commonAncestorContainer)) {
        savedEditorRange = range.cloneRange();
    }
}

function restoreEditorSelection() {
    if (!richEditor) return;

    richEditor.focus();

    const selection = window.getSelection();
    if (!selection) return;

    selection.removeAllRanges();

    if (savedEditorRange) {
        selection.addRange(savedEditorRange);
        return;
    }

    const range = document.createRange();
    range.selectNodeContents(richEditor);
    range.collapse(false);
    selection.addRange(range);
}

function insertImageAtEditorCaret(src, alt = "Note image", pendingId = "") {
    if (!richEditor) return;

    restoreEditorSelection();

    const image = document.createElement("img");
    image.className = "inline-note-image";
    image.src = src;
    image.alt = alt;

    if (pendingId) {
        image.dataset.pendingImage = pendingId;
    }

    const selection = window.getSelection();
    const range = selection?.rangeCount ? selection.getRangeAt(0) : null;

    if (range && richEditor.contains(range.commonAncestorContainer)) {
        range.deleteContents();
        range.insertNode(image);
        range.setStartAfter(image);
        range.setEndAfter(image);
        selection.removeAllRanges();
        selection.addRange(range);
    } else {
        richEditor.appendChild(image);
    }

    richEditor.insertAdjacentHTML("beforeend", "");
    saveEditorSelection();
    syncRichContent();
    markEditorDirty();
}

function noteStorageKey() {
    return noteId ? `note:${noteId}` : `create:${window.location.pathname}`;
}

function openNoteDb() {
    return new Promise((resolve, reject) => {
        if (!("indexedDB" in window)) {
            reject(new Error("IndexedDB is not available"));
            return;
        }

        const request = indexedDB.open(NOTE_DB_NAME, NOTE_DB_VERSION);

        request.onupgradeneeded = () => {
            const db = request.result;

            if (!db.objectStoreNames.contains("drafts")) {
                db.createObjectStore("drafts", { keyPath: "key" });
            }

            if (!db.objectStoreNames.contains("pendingSaves")) {
                db.createObjectStore("pendingSaves", { keyPath: "key" });
            }
        };

        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

async function writeStore(storeName, value) {
    const db = await openNoteDb();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, "readwrite");

        transaction.objectStore(storeName).put(value);
        transaction.oncomplete = () => resolve();
        transaction.onerror = () => reject(transaction.error);
    });
}

async function deleteFromStore(storeName, key) {
    const db = await openNoteDb();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, "readwrite");

        transaction.objectStore(storeName).delete(key);
        transaction.oncomplete = () => resolve();
        transaction.onerror = () => reject(transaction.error);
    });
}

async function readAllStore(storeName) {
    const db = await openNoteDb();

    return new Promise((resolve, reject) => {
        const transaction = db.transaction(storeName, "readonly");
        const request = transaction.objectStore(storeName).getAll();

        request.onsuccess = () => resolve(request.result || []);
        request.onerror = () => reject(request.error);
    });
}

function buildAutosavePayload() {
    syncRichContent();

    const sourceData = new FormData(noteForm);
    const payload = {
        title: String(sourceData.get("title") || "").trim() || "Untitled note",
        content: String(sourceData.get("content") || ""),
        font_size: String(sourceData.get("font_size") || "16"),
        is_pinned: sourceData.has("is_pinned") ? "1" : "0",
        tags: sourceData
            .getAll("tags[]")
            .map((tag) => String(tag || "").trim())
            .filter(Boolean),
        share_emails: String(sourceData.get("share_emails") || "").trim(),
        share_permission: String(sourceData.get("share_permission") || "read"),
    };

    return payload;
}

function payloadToFormData(payload, mode = autosaveMode, imageBatch = []) {
    const formData = new FormData();

    formData.set("title", payload.title || "Untitled note");
    formData.set("content", payload.content || "");
    formData.set("font_size", payload.font_size || "16");

    if (payload.is_pinned === "1" || payload.is_pinned === true) {
        formData.set("is_pinned", "1");
    }

    (payload.tags || []).forEach((tag) => formData.append("tags[]", tag));
    formData.set("share_emails", payload.share_emails || "");
    formData.set("share_permission", payload.share_permission || "read");

    imageBatch.forEach(({ file }) => formData.append("images[]", file));

    if (mode === "edit") {
        formData.set("_method", "PUT");
    }

    return formData;
}

function buildPayloadHash(payload = buildAutosavePayload()) {
    return JSON.stringify(payload);
}

function formHasDraftContent() {
    const payload = buildAutosavePayload();

    return payload.title !== "Untitled note" || payload.content.trim() !== "";
}

function applyCreateResult(data) {
    if (!noteForm || !data?.note?.id) return;

    noteId = String(data.note.id);
    autosaveMode = "edit";
    noteForm.dataset.noteId = noteId;
    noteForm.dataset.autosaveMode = "edit";

    if (data.update_url) {
        autosaveUrl = data.update_url;
        noteForm.dataset.autosaveUrl = data.update_url;
        noteForm.action = data.update_url;
    }

    if (data.show_url) {
        window.history.replaceState({}, "", data.show_url);
    }
}

async function persistOfflineDraft(payload) {
    const record = {
        key: noteStorageKey(),
        noteId,
        mode: autosaveMode || "create",
        url: autosaveUrl,
        payload,
        updatedAt: Date.now(),
    };

    try {
        await writeStore("drafts", record);
        await writeStore("pendingSaves", record);
    } catch {
        // IndexedDB can be unavailable in private browsing; the editor should still work online.
    }
}

async function sendAutosave(payload, mode = autosaveMode, url = autosaveUrl) {
    const token = document.querySelector("meta[name='csrf-token']")?.content;
    const controller = new AbortController();
    const timeout = window.setTimeout(() => controller.abort(), AUTOSAVE_TIMEOUT);
    currentUploadBatch = pendingImageFiles.slice();

    try {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                ...(realtimeSocketId ? { "X-Socket-ID": realtimeSocketId } : {}),
            },
            body: payloadToFormData(payload, mode, currentUploadBatch),
            signal: controller.signal,
        });

        if (!response.ok) {
            throw new Error("Autosave failed");
        }

        return await response.json();
    } finally {
        window.clearTimeout(timeout);
    }
}

function applyUploadedImageUrls(imageUrls = []) {
    if (!richEditor || !imageUrls.length || !currentUploadBatch.length) return false;

    let replaced = false;

    currentUploadBatch.forEach((pendingImage, index) => {
        const imageUrl = imageUrls[index];
        const image = richEditor.querySelector(`[data-pending-image="${pendingImage.id}"]`);

        if (!imageUrl || !image) return;

        URL.revokeObjectURL(image.src);
        image.src = imageUrl;
        image.removeAttribute("data-pending-image");
        replaced = true;
    });

    const uploadedIds = new Set(currentUploadBatch.map((pendingImage) => pendingImage.id));
    pendingImageFiles = pendingImageFiles.filter((pendingImage) => !uploadedIds.has(pendingImage.id));
    currentUploadBatch = [];

    if (replaced) {
        syncRichContent();
    }

    return replaced;
}

function removeSharedEmails(sharedEmails = []) {
    if (!sharedEmails.length) return;

    document.querySelectorAll("[data-email-editor]").forEach((editor) => {
        const sharedSet = new Set(sharedEmails.map((email) => email.toLowerCase()));

        editor.querySelectorAll("[data-email-item]").forEach((item) => {
            const email = item.dataset.emailValue?.toLowerCase();

            if (email && sharedSet.has(email)) {
                item.remove();
            }
        });

        syncEmailValue(editor);
    });
}

async function saveCurrentNoteNow() {
    if (!noteForm || !autosaveUrl || autosaveInProgress) {
        autosavePending = Boolean(autosaveInProgress);
        return;
    }

    if (autosaveMode === "create" && !formHasDraftContent()) {
        updateSaveState("Saved");
        return;
    }

    const payload = buildAutosavePayload();
    const currentHash = buildPayloadHash(payload);
    const queuedKey = noteStorageKey();

    if (currentHash === lastSavedHash) {
        updateSaveState("Saved");
        return;
    }

    await persistOfflineDraft(payload);

    if (!navigator.onLine) {
        updateSaveState("Offline - queued", "offline");
        return;
    }

    autosaveInProgress = true;
    lastAutosaveStartedAt = Date.now();
    updateSaveState("Saving...");

    try {
        const data = await sendAutosave(payload);

        if (autosaveMode === "create") {
            applyCreateResult(data);
        }

        const replacedImages = applyUploadedImageUrls(data.image_urls || []);
        removeSharedEmails(data.shared_emails || []);

        lastSavedHash = buildPayloadHash();
        firstDirtyAt = null;
        autosavePending = replacedImages;
        updateSaveState("Saved");
        await deleteFromStore("pendingSaves", queuedKey);
        await deleteFromStore("drafts", queuedKey);
    } catch {
        await persistOfflineDraft(payload);
        updateSaveState(navigator.onLine ? "Save queued" : "Offline - queued", navigator.onLine ? "" : "offline");
    } finally {
        autosaveInProgress = false;

        if (autosavePending) {
            autosavePending = false;
            debounceAutosave(AUTOSAVE_FAST_DELAY);
        }
    }
}

function debounceAutosave(delay = AUTOSAVE_IDLE_DELAY) {
    if (!noteForm || !autosaveUrl || applyingRemoteUpdate) return;

    window.clearTimeout(autosaveTimer);

    const now = Date.now();
    const dirtyFor = firstDirtyAt ? now - firstDirtyAt : 0;
    const sinceLastSave = now - lastAutosaveStartedAt;

    delay = Math.min(delay, AUTOSAVE_MAX_WAIT);

    if (dirtyFor >= AUTOSAVE_MAX_WAIT && sinceLastSave >= AUTOSAVE_MIN_INTERVAL) {
        delay = 0;
    } else if (sinceLastSave < AUTOSAVE_MIN_INTERVAL) {
        delay = Math.max(delay, AUTOSAVE_MIN_INTERVAL - sinceLastSave);
    }

    autosaveTimer = window.setTimeout(saveCurrentNoteNow, delay);
}

function markEditorDirty() {
    if (!firstDirtyAt) {
        firstDirtyAt = Date.now();
    }

    autosavePending = true;
    updateSaveState(navigator.onLine ? "Saving..." : "Offline - queued", navigator.onLine ? "" : "offline");
    debounceAutosave();
}

function markRichEditorChangedSoon(delay = 0) {
    window.setTimeout(() => {
        syncRichContent();
        saveEditorSelection();
        markEditorDirty();
    }, delay);
}

richEditor?.addEventListener("keyup", saveEditorSelection);
richEditor?.addEventListener("mouseup", saveEditorSelection);
richEditor?.addEventListener("input", () => {
    saveEditorSelection();
    syncRichContent();
    markEditorDirty();
});
richEditor?.addEventListener("beforeinput", (event) => {
    if (
        [
            "deleteContentBackward",
            "deleteContentForward",
            "deleteByCut",
            "historyUndo",
            "historyRedo",
        ].includes(event.inputType)
    ) {
        markRichEditorChangedSoon();
    }
});
richEditor?.addEventListener("keydown", (event) => {
    const key = event.key.toLowerCase();
    const isUndoRedo = (event.ctrlKey || event.metaKey) && ["z", "y"].includes(key);

    if (["backspace", "delete"].includes(key) || isUndoRedo) {
        markRichEditorChangedSoon();
    }
});
document.addEventListener("selectionchange", saveEditorSelection);

noteForm?.querySelectorAll('input[type="file"][name="images[]"]').forEach((input) => {
    input.addEventListener("click", saveEditorSelection);
    input.addEventListener("change", () => {
        const files = [...input.files || []].filter((file) => file.type.startsWith("image/"));

        for (const file of files) {
            const pendingImage = {
                id: `pending-${nextPendingImageId++}`,
                file,
            };

            pendingImageFiles.push(pendingImage);
            insertImageAtEditorCaret(
                URL.createObjectURL(file),
                file.name || "Note image",
                pendingImage.id
            );
        }

        input.value = "";
    });
});

/* =========================================================
   TAG INPUT
========================================================= */

function tagValues(editor = document) {
    return [...editor.querySelectorAll('input[name="tags[]"]')]
        .map((input) => input.value.trim())
        .filter(Boolean);
}

function tagExists(value, editor, exceptValue = "") {
    const normalizedValue = value.trim().toLowerCase();
    const normalizedExcept = exceptValue.trim().toLowerCase();

    return tagValues(editor).some((tag) => {
        const normalizedTag = tag.toLowerCase();
        return normalizedTag === normalizedValue && normalizedTag !== normalizedExcept;
    });
}

function createTagElement(tag) {
    const item = document.createElement("span");
    item.className = "editable-tag";
    item.dataset.tagItem = "";

    const textButton = document.createElement("button");
    textButton.className = "editable-tag-text";
    textButton.type = "button";
    textButton.dataset.tagEdit = "";
    textButton.textContent = tag;

    const removeButton = document.createElement("button");
    removeButton.className = "editable-tag-remove";
    removeButton.type = "button";
    removeButton.dataset.tagRemove = "";
    removeButton.setAttribute("aria-label", `Remove ${tag}`);
    removeButton.innerHTML = '<i class="bi bi-x"></i>';

    const hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "tags[]";
    hiddenInput.value = tag;

    item.append(textButton, removeButton, hiddenInput);

    return item;
}

function addTag(tag, editor) {
    const value = tag.trim();
    if (!value || tagExists(value, editor)) return false;

    editor.querySelector("[data-tag-list]")?.appendChild(createTagElement(value));
    refreshExistingTagOptions(editor);
    markEditorDirty();

    return true;
}

function refreshExistingTagOptions(editor) {
    const existingTagSelect = editor.querySelector("[data-existing-tag-select]");
    if (!existingTagSelect) return;

    const selectedTags = tagValues(editor).map((tag) => tag.toLowerCase());

    [...existingTagSelect.options].forEach((option) => {
        if (!option.value) return;

        option.hidden = selectedTags.includes(option.value.trim().toLowerCase());
    });

    existingTagSelect.customSelectRefresh?.();
}

function beginTagEdit(textButton, editor) {
    const item = textButton.closest("[data-tag-item]");
    const hiddenInput = item?.querySelector('input[name="tags[]"]');
    if (!item || !hiddenInput || item.querySelector("[data-tag-edit-input]")) return;

    const oldValue = hiddenInput.value.trim();
    const input = document.createElement("input");
    input.className = "tag-edit-input";
    input.type = "text";
    input.value = oldValue;
    input.dataset.tagEditInput = "";

    textButton.hidden = true;
    textButton.after(input);
    input.focus();
    input.select();

    function cancelEdit() {
        input.remove();
        textButton.hidden = false;
    }

    function saveEditedTag() {
        const newValue = input.value.trim();

        if (!newValue) {
            item.remove();
            markEditorDirty();
            return;
        }

        if (tagExists(newValue, editor, oldValue)) {
            input.value = oldValue;
            cancelEdit();
            return;
        }

        textButton.textContent = newValue;
        hiddenInput.value = newValue;
        item.querySelector("[data-tag-remove]")?.setAttribute("aria-label", `Remove ${newValue}`);
        cancelEdit();
        refreshExistingTagOptions(editor);
        markEditorDirty();
    }

    input.addEventListener("keydown", (event) => {
        if (event.key === "Enter") {
            event.preventDefault();
            saveEditedTag();
        }

        if (event.key === "Escape") {
            event.preventDefault();
            cancelEdit();
        }
    });

    input.addEventListener("blur", saveEditedTag);
}

document.querySelectorAll("[data-tag-editor]").forEach((tagEditor) => {
    const input = tagEditor.querySelector("[data-tag-input]");
    const existingTagSelect = tagEditor.querySelector("[data-existing-tag-select]");

    input?.addEventListener("keydown", (event) => {
        if (event.key !== "Enter") return;

        event.preventDefault();

        if (addTag(input.value, tagEditor)) {
            input.value = "";
        }
    });

    existingTagSelect?.addEventListener("change", () => {
        addTag(existingTagSelect.value, tagEditor);
        existingTagSelect.value = "";
        existingTagSelect.customSelectRefresh?.();
    });

    refreshExistingTagOptions(tagEditor);

    tagEditor.addEventListener("dblclick", (event) => {
        const editButton = event.target.closest("[data-tag-edit]");
        if (editButton && !editButton.disabled) {
            beginTagEdit(editButton, tagEditor);
        }
    });

    tagEditor.addEventListener("click", (event) => {
        const removeButton = event.target.closest("[data-tag-remove]");
        if (!removeButton) return;

        removeButton.closest("[data-tag-item]")?.remove();
        refreshExistingTagOptions(tagEditor);
        markEditorDirty();
    });
});

/* =========================================================
   SHARE RECIPIENT INPUT
========================================================= */

function emailValues(editor) {
    return [...editor.querySelectorAll("[data-email-item]")]
        .map((item) => item.dataset.emailValue || "")
        .filter(Boolean);
}

function syncEmailValue(editor) {
    const input = editor.closest(".field")?.querySelector("[data-share-email-value]");
    if (input) {
        input.value = emailValues(editor).join(", ");
    }
}

function createEmailElement(email) {
    const item = document.createElement("span");
    item.className = "editable-tag";
    item.dataset.emailItem = "";
    item.dataset.emailValue = email;

    const textButton = document.createElement("button");
    textButton.className = "editable-tag-text";
    textButton.type = "button";
    textButton.textContent = email;

    const removeButton = document.createElement("button");
    removeButton.className = "editable-tag-remove";
    removeButton.type = "button";
    removeButton.dataset.emailRemove = "";
    removeButton.setAttribute("aria-label", `Remove ${email}`);
    removeButton.innerHTML = '<i class="bi bi-x"></i>';

    item.append(textButton, removeButton);

    return item;
}

function addShareEmail(email, editor) {
    const value = email.trim().replace(/,$/, "").toLowerCase();

    if (!value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return false;
    if (emailValues(editor).some((existingEmail) => existingEmail.toLowerCase() === value)) return false;

    editor.querySelector("[data-email-list]")?.appendChild(createEmailElement(value));
    syncEmailValue(editor);
    markEditorDirty();

    return true;
}

document.querySelectorAll("[data-email-editor]").forEach((emailEditor) => {
    const input = emailEditor.querySelector("[data-email-input]");

    input?.addEventListener("keydown", (event) => {
        if (!["Enter", ",", ";"].includes(event.key)) return;

        event.preventDefault();

        if (addShareEmail(input.value, emailEditor)) {
            input.value = "";
        }
    });

    input?.addEventListener("blur", () => {
        if (addShareEmail(input.value, emailEditor)) {
            input.value = "";
        }
    });

    emailEditor.addEventListener("click", (event) => {
        const removeButton = event.target.closest("[data-email-remove]");
        if (!removeButton) return;

        removeButton.closest("[data-email-item]")?.remove();
        syncEmailValue(emailEditor);
        markEditorDirty();
    });

    syncEmailValue(emailEditor);
});

/* =========================================================
   FONT SIZE
========================================================= */

document
    .querySelector("[data-font-size-control]")
    ?.addEventListener("input", (event) => {
        richEditor?.style.setProperty(
            "--note-font-size",
            `${event.target.value}px`
        );
    });

/* =========================================================
   EDITOR COMMANDS
========================================================= */

document.querySelectorAll("[data-editor-command]").forEach((button) => {
    button.addEventListener("click", () => {
        richEditor?.focus();

        const command = button.dataset.editorCommand;

        if (command === "uppercase") {
            const selection = window.getSelection();

            if (
                !selection ||
                selection.rangeCount === 0 ||
                selection.isCollapsed
            ) {
                return;
            }

            const range = selection.getRangeAt(0);

            const text = range.toString().toUpperCase();

            range.deleteContents();

            range.insertNode(document.createTextNode(text));

            selection.removeAllRanges();

            syncRichContent();
            markEditorDirty();

            return;
        }

        document.execCommand(command, false, null);

        syncRichContent();
        markEditorDirty();
    });
});

/* =========================================================
   OFFLINE SYNC + REALTIME
========================================================= */

async function syncPendingSaves() {
    let records = [];

    try {
        records = await readAllStore("pendingSaves");
    } catch {
        return;
    }

    for (const record of records) {
        if (!record?.url || !record?.payload) continue;

        try {
            const data = await sendAutosave(record.payload, record.mode, record.url);

            if (record.mode === "create" && record.key === noteStorageKey()) {
                applyCreateResult(data);
            }

            await deleteFromStore("pendingSaves", record.key);
            await deleteFromStore("drafts", record.key);

            if (record.key === noteStorageKey()) {
                lastSavedHash = buildPayloadHash();
                firstDirtyAt = null;
                autosavePending = false;
            }
        } catch {
            updateSaveState("Sync queued", "offline");
            return;
        }
    }

    updateSaveState("Saved");
}

function applyRemoteNote(note) {
    if (!noteForm || !note) return;

    applyingRemoteUpdate = true;

    const titleInput = noteForm.querySelector('input[name="title"]');
    const pinnedInput = noteForm.querySelector('input[name="is_pinned"]');
    const fontSizeInput = noteForm.querySelector('input[name="font_size"]');

    if (titleInput) {
        titleInput.value = note.title || "Untitled note";
    }

    if (contentInput) {
        contentInput.value = note.content || "";
    }

    if (richEditor) {
        richEditor.innerHTML = note.content || "";
        richEditor.style.setProperty("--note-font-size", `${note.font_size || 16}px`);
    }

    if (fontSizeInput) {
        fontSizeInput.value = note.font_size || 16;
    }

    if (pinnedInput) {
        pinnedInput.checked = Boolean(note.is_pinned);
    }

    lastSavedHash = buildPayloadHash();
    firstDirtyAt = null;
    autosavePending = false;
    updateSaveState("Live update", "live");

    window.setTimeout(() => {
        updateSaveState("Saved");
        applyingRemoteUpdate = false;
    }, 1200);
}

async function subscribeToRealtimeNote() {
    const channelName = noteForm?.dataset.realtimeChannel;
    const key =
        import.meta.env.VITE_REVERB_APP_KEY ||
        import.meta.env.VITE_PUSHER_APP_KEY;

    if (!channelName || !key || !("WebSocket" in window)) return;

    const scheme = (import.meta.env.VITE_REVERB_SCHEME || import.meta.env.VITE_PUSHER_SCHEME || "http") === "https" ? "wss" : "ws";
    const host = import.meta.env.VITE_REVERB_HOST || import.meta.env.VITE_PUSHER_HOST || window.location.hostname;
    const port = import.meta.env.VITE_REVERB_PORT || import.meta.env.VITE_PUSHER_PORT || "8080";
    const wsUrl = `${scheme}://${host}:${port}/app/${key}?protocol=7&client=notenest&version=1.0&flash=false`;
    const socket = new WebSocket(wsUrl);

    socket.addEventListener("message", async (event) => {
        const message = JSON.parse(event.data || "{}");

        if (message.event === "pusher:connection_established") {
            const socketData = JSON.parse(message.data || "{}");
            realtimeSocketId = socketData.socket_id || "";
            const token = document.querySelector("meta[name='csrf-token']")?.content;
            const authResponse = await fetch("/broadcasting/auth", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    socket_id: socketData.socket_id,
                    channel_name: channelName,
                }),
            });

            if (!authResponse.ok) return;

            const auth = await authResponse.json();

            socket.send(JSON.stringify({
                event: "pusher:subscribe",
                data: {
                    channel: channelName,
                    auth: auth.auth,
                },
            }));

            return;
        }

        if (message.event !== "note.updated") return;

        const data = typeof message.data === "string"
            ? JSON.parse(message.data)
            : message.data;
        const currentUserId = Number(document.querySelector("meta[name='user-id']")?.content || 0);

        if (Number(data.editor_id) === currentUserId) return;

        applyRemoteNote(data.note);
    });

    socket.addEventListener("open", () => updateSaveState("Realtime connected", "live"));
}

syncPendingSaves();
subscribeToRealtimeNote();

let syncRetryTimer = null;

function queueOfflineSync(delay = 0) {
    if (!noteForm || syncRetryTimer) return;

    syncRetryTimer = window.setTimeout(async () => {
        syncRetryTimer = null;
        updateSaveState("Syncing...");
        await syncPendingSaves();

        if (buildPayloadHash() !== lastSavedHash) {
            debounceAutosave(AUTOSAVE_FAST_DELAY);
        }
    }, delay);
}

/* =========================================================
   FORM SUBMIT
========================================================= */

noteForm?.addEventListener("submit", (event) => {
    event.preventDefault();
    syncRichContent();
    window.clearTimeout(autosaveTimer);
    saveCurrentNoteNow();
});

document.querySelectorAll("[data-autosave-field]").forEach((field) => {
    const eventName =
        ["checkbox", "radio", "file"].includes(field.type)
            ? "change"
            : "input";

    field.addEventListener(eventName, () => {
        markEditorDirty();
    });
});

window.addEventListener("online", async () => {
    queueOfflineSync();
});

window.addEventListener("offline", () => {
    if (noteForm && buildPayloadHash() !== lastSavedHash) {
        updateSaveState("Offline - queued", "offline");
    }
});

document.addEventListener("visibilitychange", () => {
    if (document.visibilityState === "hidden") {
        window.clearTimeout(autosaveTimer);
        saveCurrentNoteNow();
    } else {
        queueOfflineSync(200);
    }
});

window.addEventListener("focus", () => queueOfflineSync(200));

if (noteForm && autosaveUrl) {
    lastSavedHash = buildPayloadHash();
    updateSaveState(navigator.onLine ? "Saved" : "Offline ready", navigator.onLine ? "" : "offline");
}

/* =========================================================
   SERVICE WORKER
========================================================= */

if ("serviceWorker" in navigator) {
    window.addEventListener("load", () => {
        navigator.serviceWorker
            .register("/sw.js")
            .catch(() => {});
    });
}
