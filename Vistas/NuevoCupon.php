                <div>
                    <label for="titulo">Título de la oferta:</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>

                <div>
                    <label for="precioRegular">Precio Regular:</label>
                    <input type="number" id="precioRegular" name="precioRegular" step="0.01" required>
                </div>

                <div>
                    <label for="precioOferta">Precio de Oferta:</label>
                    <input type="number" id="precioOferta" name="precioOferta" step="0.01" required>
                </div>

                <div>
                    <label for="fechaInicio">Fecha de inicio:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" required>
                </div>

                <div>
                    <label for="fechaFin">Fecha de fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin" required>
                </div>

                <div>
                    <label for="fechaCanje">Fecha límite para canjear:</label>
                    <input type="date" id="fechaCanje" name="fechaCanje" required>
                </div>

                <div>
                    <label for="cantidad">Cantidad de cupones (opcional):</label>
                    <input type="number" id="cantidad" name="cantidad" min="0">
                </div>

                <div>
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required></textarea>
                </div>

                <div>
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" required>
                        <option value="disponible">Disponible</option>
                        <option value="no_disponible">No Disponible</option>
                    </select>
                </div>

                <button type="submit">Guardar Oferta</button>
                <button type="button" onclick="cancelarEdicion()">Cancelar</button>
            </form>