function copyToClipboard(item, message) {
    if (!navigator.clipboard) {
        // fallback
        const ta = document.createElement('textarea');
        ta.value = item;
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); } catch(e) {}
        ta.remove();
        Livewire.dispatch('toast', { payload: { message } })
        return;
    }

    navigator.clipboard.writeText(item).then(() => {
        Livewire.dispatch('toast', { payload: { message } })
    }).catch(() => {
        Livewire.dispatch('toast', { payload: { message: 'Copying failed' } })
    });
}