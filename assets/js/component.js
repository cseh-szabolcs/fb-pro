export function component(data, name = 'root', start = true) {
    const factory = typeof data !== 'function'
        ? () => data
        : function() { return data.apply(this, [this]); };

    Alpine.data(name, factory);
    if (start) Alpine.start();
}
